package com.pplview.parita.pplview;

import android.app.ProgressDialog;
import android.content.Intent;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;
import java.util.List;

public class ActivityLog extends AppCompatActivity {
    TextView etUsername, nocomment;
    String myemail;
    String EmailHolder;


    public static final int CONNECTION_TIMEOUT = 20000;
    public static final int READ_TIMEOUT = 20000;
    private RecyclerView mRVFish;
    private TimelineAdapter mAdapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_log);
        //getting the user emailid from Account info Activity as intent data
        etUsername=(TextView)findViewById(R.id.etUsername);
        Intent intent = getIntent();
        EmailHolder = intent.getStringExtra("email");
        etUsername.setText(EmailHolder);
        myemail= etUsername.getText().toString().trim();


        nocomment=(TextView)findViewById(R.id.nocomment);

        new AsyncFetch(myemail).execute();
    }
    //fetching the user details from the table where user's registering details are stored via using email id of the logged user
    public class AsyncFetch extends AsyncTask<String, String, String> {

        ProgressDialog pdLoading = new ProgressDialog(ActivityLog.this);
        HttpURLConnection conn;
        URL url = null;
        String searchQuery;

        public AsyncFetch(String searchQuery){
            this.searchQuery=searchQuery;
        }

        @Override
        protected void onPreExecute() {
            super.onPreExecute();

            //this method will be running on UI thread
            pdLoading.setMessage("\tLoading...");
            pdLoading.setCancelable(false);
            pdLoading.show();

        }

        @Override
        protected String doInBackground(String... params) {
            try {

                // Enter URL address where your php file resides
                url = new URL("https://paritasampa95.000webhostapp.com/PeopleView/ActivityLog.php");

            } catch (MalformedURLException e) {
                // TODO Auto-generated catch block
                e.printStackTrace();
                return e.toString();
            }
            try {

                // Setup HttpURLConnection class to send and receive data from php and mysql
                conn = (HttpURLConnection) url.openConnection();
                conn.setReadTimeout(READ_TIMEOUT);
                conn.setConnectTimeout(CONNECTION_TIMEOUT);
                conn.setRequestMethod("POST");

                // setDoInput and setDoOutput to true as we send and recieve data
                conn.setDoInput(true);
                conn.setDoOutput(true);

                // add parameter to our above url
                Uri.Builder builder = new Uri.Builder().appendQueryParameter("myemail", myemail);
                String query = builder.build().getEncodedQuery();

                OutputStream os = conn.getOutputStream();
                BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(os, "UTF-8"));
                writer.write(query);
                writer.flush();
                writer.close();
                os.close();
                conn.connect();

            } catch (IOException e1) {
                // TODO Auto-generated catch block
                e1.printStackTrace();
                return e1.toString();
            }

            try {

                int response_code = conn.getResponseCode();

                // Check if successful connection made
                if (response_code == HttpURLConnection.HTTP_OK) {

                    // Read data sent from server
                    InputStream input = conn.getInputStream();
                    BufferedReader reader = new BufferedReader(new InputStreamReader(input));
                    StringBuilder result = new StringBuilder();
                    String line;

                    while ((line = reader.readLine()) != null) {
                        result.append(line);
                    }

                    // Pass data to onPostExecute method
                    return (result.toString());

                } else {
                    return("Connection error");
                }

            } catch (IOException e) {
                e.printStackTrace();
                return e.toString();
            } finally {
                conn.disconnect();
            }


        }

        @Override
        protected void onPostExecute(String result) {

            //this method will be running on UI thread
            pdLoading.dismiss();
            List<Timeline> data=new ArrayList<>();

            pdLoading.dismiss();
            if(result.equals("no rows")) {
                Toast.makeText(ActivityLog.this, "No Results found ", Toast.LENGTH_LONG).show();
            }else{

                try {

                    JSONArray jArray = new JSONArray(result);

                    // Extract data from json and store into ArrayList as class objects
                    for (int i = 0; i < jArray.length(); i++) {
                        JSONObject json_data = jArray.getJSONObject(i);
                        Timeline product = new Timeline();
                        product.heading = json_data.getString("heading");
                        product.description = json_data.getString("description");
                        product.comment=json_data.getString("comment");
                        product.userposttime=json_data.getString("userposttime");
                        data.add(product);
                    }

                    // Setup and Handover data to recyclerview
                    mRVFish = (RecyclerView)findViewById(R.id.recycler_view);
                    mRVFish.addItemDecoration(new background(ActivityLog.this));
                    mAdapter = new TimelineAdapter(ActivityLog.this, data);
                    mRVFish.setAdapter(mAdapter);
                    mRVFish.setLayoutManager(new LinearLayoutManager(ActivityLog.this));



                } catch (JSONException e) {
                    // You to understand what actually error is and handle it appropriately
                    Log.d(e.toString(),"error");
                    //Log.d(result.toString(),"errortoshow");
                    //   Toast.makeText(MyOrderList.this, e.toString(), Toast.LENGTH_LONG).show();
                  //  Toast.makeText(ActivityLog.this, "No history is present", Toast.LENGTH_LONG).show();
                    nocomment.setVisibility(View.VISIBLE);

                }

            }

        }

    }
}
