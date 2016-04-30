package spaceapps.droneapp;
import android.app.ProgressDialog;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;

import android.content.Intent;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import org.java_websocket.util.Base64;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.io.UnsupportedEncodingException;
import java.io.Writer;
import java.net.HttpURLConnection;
import java.net.URL;

import butterknife.ButterKnife;
import butterknife.InjectView;

import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.Formatter;

public class LoginActivity extends AppCompatActivity {
    private static final String TAG = "LoginActivity";
    private static final int REQUEST_SIGNUP = 0;
    private static final int REQUEST_LOGIN = 0;
    ProgressDialog progressDialog;
    @InjectView(R.id.input_email) EditText _emailText;
    @InjectView(R.id.input_password) EditText _passwordText;
    @InjectView(R.id.btn_login) Button _loginButton;
    @InjectView(R.id.link_signup) TextView _signupLink;
    //hasheo



    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.login);
        ButterKnife.inject(this);



        _loginButton.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                login();
            }
        });

        _signupLink.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                // Start the Signup activity
                Intent intent = new Intent(getApplicationContext(), SignupActivity.class);
                startActivityForResult(intent, REQUEST_SIGNUP);
            }
        });
    }


    public void login() {



        if (!validate()) {
            onLoginFailed();
            return;
        }

        _loginButton.setEnabled(false);




        String email = _emailText.getText().toString();
        String password = generateHash(_passwordText.getText().toString());



        // TODO: Implement your own authentication logic here.
        JSONObject post_dict = new JSONObject();

        try {
            post_dict.put("us", email);
            post_dict.put("pas", password);


        } catch (JSONException e) {
            e.printStackTrace();
        }

        new CheckLogin().execute(String.valueOf(post_dict));
    }

    public final static String encryptSHA512(String target) {
        try {
            MessageDigest sh = MessageDigest.getInstance("SHA-512");
            sh.update(target.getBytes());
            StringBuffer sb = new StringBuffer();
            for (byte b : sh.digest()) sb.append(Integer.toHexString(0xff & b));
            return sb.toString();
        } catch (Exception e) {
            throw new RuntimeException(e);
        }
    }
    public String generateHash(String toHash) {

        MessageDigest md = null;
        byte[] hash = null;
        try {
            md = MessageDigest.getInstance("SHA-512");
            hash = md.digest(toHash.getBytes("UTF-8"));
        } catch (NoSuchAlgorithmException e) {
            e.printStackTrace();
        } catch (UnsupportedEncodingException e) {
            e.printStackTrace();
        }
        return convertToHex(hash);
    }

    /**
     * Converts the given byte[] to a hex string.
     * @param raw the byte[] to convert
     * @return the string the given byte[] represents
     */
    private String convertToHex(byte[] raw) {
        StringBuffer sb = new StringBuffer();
        for (int i = 0; i < raw.length; i++) {
            sb.append(Integer.toString((raw[i] & 0xff) + 0x100, 16).substring(1));
        }
        return sb.toString();
    }
    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        if (requestCode == REQUEST_SIGNUP) {
            if (resultCode == RESULT_OK) {

                // TODO: Implement successful signup logic here
                // By default we just finish the Activity and log them in automatically
                this.finish();
            }
        }
    }

    @Override
    public void onBackPressed() {
        // disable going back to the MainActivity
        moveTaskToBack(true);
    }

    public void onLoginSuccess(Integer rsp) {

        _loginButton.setEnabled(true);
        Intent intent = new Intent(getApplicationContext(), index.class);
        intent.putExtra("iddispositivo",String.valueOf(rsp));
        startActivityForResult(intent, REQUEST_LOGIN);
        finish();
    }

    public void onLoginFailed() {

        Toast.makeText(getBaseContext(), "Datos erroneos", Toast.LENGTH_LONG).show();

        _loginButton.setEnabled(true);
    }

    public boolean validate() {
        boolean valid = true;

        String email = _emailText.getText().toString();
        String password = _passwordText.getText().toString();

        if (email.isEmpty() || !android.util.Patterns.EMAIL_ADDRESS.matcher(email).matches()) {
            _emailText.setError("Ingrese un email válido.");
            valid = false;
        } else {
            _emailText.setError(null);
        }

        if (password.isEmpty() || password.length() < 4) {
            _passwordText.setError("Ingrese una contraseña válida.");
            valid = false;
        } else {
            _passwordText.setError(null);
        }

        return valid;
    }

    public class CheckLogin extends AsyncTask<String, Void, Integer> {


        protected void onPreExecute() {
            super.onPreExecute();
            progressDialog = new ProgressDialog(LoginActivity.this);
            progressDialog.setIndeterminate(true);
            progressDialog.setMessage("Verificando...");
            progressDialog.show();

        }

        @Override
        protected Integer doInBackground(String... params) {
            String identifier = params[0];


            HttpURLConnection urlConnection = null;
            BufferedReader reader = null;

            try {
                URL url = new URL("http://spaceappsros.cloudapp.net/joaquin/db/login.php");
                urlConnection = (HttpURLConnection) url.openConnection();
                urlConnection.setDoOutput(true);

                urlConnection.setRequestMethod("POST");

                urlConnection.setRequestProperty("Content-Type", "application/json");
                urlConnection.setRequestProperty("Accept", "application/json");

                //set headers and method
                Writer writer = new BufferedWriter(new OutputStreamWriter(urlConnection.getOutputStream(), "UTF-8"));
                writer.write(identifier);

                writer.flush();
                // json data
                writer.close();

                InputStream inputStream = urlConnection.getInputStream();
                //input stream

                reader = new BufferedReader(new InputStreamReader(inputStream));

                String inputLine;
                while ((inputLine = reader.readLine()) != null) {
                    final int line=Integer.parseInt(inputLine);
                    if(line!=0){
                        return line;
                    }else{
                        return 0;
                    }

                }
            } catch (final Exception e) {


            } finally {
                if (urlConnection != null) {
                    urlConnection.disconnect();
                }

            }

            return 0;

        }

        protected void onPostExecute(Integer result) {
            super.onPostExecute(result);
            progressDialog.dismiss();
            if(result!=0){
                onLoginSuccess(result);
            }else {
                onLoginFailed();
            }
        }
    }
}