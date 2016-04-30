package spaceapps.droneapp;

import android.app.ProgressDialog;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

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
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;

import butterknife.ButterKnife;
import butterknife.InjectView;

public class SignupActivity extends AppCompatActivity {
    private static final String TAG = "SignupActivity";

    @InjectView(R.id.input_email) EditText _emailText;
    @InjectView(R.id.input_password) EditText _passwordText;
    @InjectView(R.id.input_repassword) EditText _repasswordText;
    @InjectView(R.id.btn_signup) Button _signupButton;
    @InjectView(R.id.link_login) TextView _loginLink;
    ProgressDialog progressDialog;
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.signup);
        ButterKnife.inject(this);

        _signupButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                signup();
            }
        });

        _loginLink.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                // Finish the registration screen and return to the Login activity
                finish();
            }
        });
    }

    public void signup() {
        Log.d(TAG, "Signup");

        if (!validate()) {

            return;
        }

        _signupButton.setEnabled(false);

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

        new Signup().execute(String.valueOf(post_dict));
        // TODO: Implement your own signup logic here.


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
    public void onSignupSuccess() {
        _signupButton.setEnabled(true);
        Intent intent = new Intent(getApplicationContext(), LoginActivity.class);

        startActivityForResult(intent,0);
        finish();
    }

    public void onSignupFailed() {
        Toast.makeText(getBaseContext(), "Error en la creación de usuario.", Toast.LENGTH_LONG).show();

        _signupButton.setEnabled(true);
    }

    public boolean validate() {
        boolean valid = true;

        String email = _emailText.getText().toString();
        String password = _passwordText.getText().toString();
        String repassword = _repasswordText.getText().toString();

        if (email.isEmpty() || !android.util.Patterns.EMAIL_ADDRESS.matcher(email).matches()) {
            _emailText.setError("Ingrese un Email válido.");
            valid = false;
        } else {
            _emailText.setError(null);
        }

        if (password.isEmpty() || password.length() < 4 || password.length() > 10) {
            _passwordText.setError("Ingrese una contraseña mas larga.");
            valid = false;
        } else {
            _passwordText.setError(null);
        }

        if ( !repassword.equals(password)) {
            _repasswordText.setError("Las contraseñas no coinciden.");
            valid = false;
        } else {
            _repasswordText.setError(null);
        }

        return valid;
    }

    public class Signup extends AsyncTask<String, Void, Integer> {


        protected void onPreExecute() {
            super.onPreExecute();
            progressDialog = new ProgressDialog(SignupActivity.this);
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
                URL url = new URL("http://spaceappsros.cloudapp.net/joaquin/db/signup.php");
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
                onSignupSuccess();
            }else {
                onSignupFailed();
            }
        }
    }
}