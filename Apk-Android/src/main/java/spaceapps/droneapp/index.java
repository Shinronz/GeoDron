package spaceapps.droneapp;

import android.Manifest;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.bluetooth.BluetoothAdapter;
import android.bluetooth.BluetoothDevice;
import android.bluetooth.BluetoothSocket;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.BatteryManager;
import android.os.Bundle;
import android.os.Handler;
import android.provider.Settings;
import android.support.design.widget.FloatingActionButton;
import android.support.v4.app.ActivityCompat;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.TextView;
import com.google.android.gms.appindexing.Action;
import com.google.android.gms.appindexing.AppIndex;
import com.google.android.gms.common.api.GoogleApiClient;
import org.java_websocket.client.WebSocketClient;
import org.java_websocket.drafts.Draft_17;
import org.java_websocket.handshake.ServerHandshake;
import org.json.JSONException;
import org.json.JSONObject;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.URI;
import java.net.URISyntaxException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.Set;
import java.util.UUID;
import android.provider.Settings.Secure;

public class index extends AppCompatActivity {
    TextView text;
    private static final int MY_PERMISSIONS_REQUEST_ACCESS_FINE_LOCATION = 1;
    LocationManager locManager;
    LocationListener locListener;
    Location ub = null;
    Location pub = null;
    Location ppub = null;
    AlertDialog alert = null;
    AlertDialog.Builder builder;
    String id = "";
    int contadorenvios = 0;

    private BluetoothAdapter mBluetoothAdapter;
    private BluetoothSocket btSocket;
    private ArrayList<BluetoothDevice> btDeviceArray = new ArrayList<BluetoothDevice>();
    private ConnectAsyncTask connectAsyncTask;
    Handler h;
    private StringBuilder sb = new StringBuilder();
    private ConnectedThread mConnectedThread;

    final int RECIEVE_MESSAGE = 1;

    String sensor1 = "Desconectado...";
    boolean b = false;
    boolean conectado = false;


    JSONObject socketconexion;
    private WebSocketClient mWebSocketClient;
    URI uri;
    //setter time
    SimpleDateFormat sdf = new SimpleDateFormat("HH:mm:ss");
    String currentDateandTime;
    boolean iniciado = false;

    private GoogleApiClient client;

    @Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_index);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        FloatingActionButton fab = (FloatingActionButton) findViewById(R.id.fab);
        Intent intent= getIntent();


        text = (TextView) findViewById(R.id.texto);
        text.setText("Iniciando...");
        View parentLayout = findViewById(R.id.app_bar);

        text.setText("Obteniendo ID de dispositivo...\r\n" + text.getText());
        id = intent.getStringExtra("iddispositivo");
        text.setText("ID Dispositivo:"+id+"\r\n" + text.getText());
        socketconexion= new JSONObject();

        try {
            socketconexion.put("source" ,"apk" );
            socketconexion.put("userid",id);


        } catch (JSONException e) {
            e.printStackTrace();
        }
        fab.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View view) {

                if (!b) {

                    mWebSocketClient = new WebSocketClient(uri, new Draft_17()) {
                        @Override
                        public void onOpen(ServerHandshake serverHandshake) {

                            mWebSocketClient.send(String.valueOf(socketconexion));
                            sendSocket myClient = new sendSocket();
                            myClient.start();

                            runOnUiThread(new Runnable() {
                                @Override
                                public void run() {

                                    text.setText("Conexión abierta" + "\r\n" + text.getText());
                                    iniciado = true;
                                }

                            });
                        }


                        @Override
                        public void onMessage(String s) {


                        }

                        @Override
                        public void onClose(int i, String s, boolean b) {

                            runOnUiThread(new Runnable() {
                                @Override
                                public void run() {
                                    text.setText("Conexión cerrada" + "\r\n" + text.getText());
                                }

                            });
                        }

                        @Override
                        public void onError(final Exception e) {

                            runOnUiThread(new Runnable() {
                                @Override
                                public void run() {
                                    text.setText("WebSocket error." + "\r\n" + e.toString());
                                }

                            });
                        }
                    };
                    mWebSocketClient.connect();
                    iniciado = true;

                    text.setText("Servicio iniciado\r\n" + text.getText());

                    b = true;

                    //conectado-> bandera de conexion con disp bluetooh apareado
                    if (!conectado) {
                        // Queryng paried devices
                        Set<BluetoothDevice> pariedDevices = mBluetoothAdapter.getBondedDevices();
                        if (pariedDevices.size() > 0) {
                            for (BluetoothDevice device : pariedDevices) {

                                text.setText("Conectando con dispositivo...\r\n" + text.getText());
                                connectAsyncTask.execute(device);
                                text.setText("Conectado a: " + device.getName() + " " + device.getAddress() + "\r\n" + text.getText());
                            }
                        } else {
                            text.setText("Error de conexion con el sensor\r\n" + text.getText());
                        }
                        conectado = true;

                    } else {

                    }

                } else {
                    //cierro la conexion
                    mWebSocketClient.close();

                    text.setText("Servicio detenido\r\n" + text.getText());
                    b = false;
                    iniciado=false;
                }

            }
        });



        // Instance AsyncTask
        connectAsyncTask = new ConnectAsyncTask();
        //Get Bluettoth Adapter
        mBluetoothAdapter = BluetoothAdapter.getDefaultAdapter();

        // Check smartphone support Bluetooth
        if (mBluetoothAdapter == null) {
            //Device does not support Bluetooth
            text.setText("Not support bluetooth\r\n" + text.getText());
            finish();
        }

        // Check Bluetooth enabled
        if (!mBluetoothAdapter.isEnabled()) {
            Intent enableBtIntent = new Intent(BluetoothAdapter.ACTION_REQUEST_ENABLE);
            startActivityForResult(enableBtIntent, 1);
        }


        builder = new AlertDialog.Builder(this);
        locManager = (LocationManager) getSystemService(Context.LOCATION_SERVICE);

        locListener = new LocationListener() {
            public void onLocationChanged(Location location) {
                ub = location;
            }

            public void onProviderDisabled(String provider) {


            }

            public void onProviderEnabled(String provider) {

            }

            public void onStatusChanged(String provider, int status, Bundle extras) {


            }
        };
        if (!locManager.isProviderEnabled(LocationManager.GPS_PROVIDER)) {
            builder.setMessage("El sistema GPS esta desactivado, ¿Desea activarlo?")
                    .setCancelable(false)
                    .setPositiveButton("Si", new DialogInterface.OnClickListener() {
                        public void onClick(@SuppressWarnings("unused") final DialogInterface dialog, @SuppressWarnings("unused") final int id) {
                            startActivity(new Intent(Settings.ACTION_LOCATION_SOURCE_SETTINGS));
                        }
                    })
                    .setNegativeButton("No", new DialogInterface.OnClickListener() {
                        public void onClick(final DialogInterface dialog, @SuppressWarnings("unused") final int id) {
                            dialog.cancel();
                        }
                    });
            alert = builder.create();
            alert.show();
        }
        //verifico permisos de ubicacion
        if (ContextCompat.checkSelfPermission(this,
                Manifest.permission.ACCESS_FINE_LOCATION)
                != PackageManager.PERMISSION_GRANTED) {

            ActivityCompat.requestPermissions(this,
                    new String[]{Manifest.permission.ACCESS_FINE_LOCATION},
                    MY_PERMISSIONS_REQUEST_ACCESS_FINE_LOCATION);


        } else {
            locManager.requestLocationUpdates(LocationManager.GPS_PROVIDER, 500, 0, locListener);
            ub = locManager.getLastKnownLocation(LocationManager.GPS_PROVIDER);
            pub=ub;
            ppub=pub;
            if (ub == null) {
                ub = locManager.getLastKnownLocation(LocationManager.NETWORK_PROVIDER);
            }

            if (ub == null) {
                ub = locManager.getLastKnownLocation(LocationManager.PASSIVE_PROVIDER);
            }
        }
        text.setText(  "Localización obtenida exitosamente...\r\n"+text.getText());

        try {
            uri = new URI("ws://spaceappsros.cloudapp.net:6789");
        } catch (URISyntaxException e) {
            e.printStackTrace();
            return;
        }
        //handler del thread del bluetooh
        h = new Handler() {
            public void handleMessage(android.os.Message msg) {
                switch (msg.what) {
                    case RECIEVE_MESSAGE:                                                   // if receive massage
                        byte[] readBuf = (byte[]) msg.obj;
                        String strIncom = new String(readBuf, 0, msg.arg1);                 // create string from bytes array
                        sb.append(strIncom);                                                // append string
                        int endOfLineIndex = sb.indexOf("\r\n");                            // determine the end-of-line
                        if (endOfLineIndex > 0) {                                            // if end-of-line,
                            String sbprint = sb.substring(0, endOfLineIndex);               // extract string
                            sb.delete(0, sb.length());                                      // and clear
                            sensor1=sbprint;


                        }

                        break;
                }

            };
        };
        // ATTENTION: This was auto-generated to implement the App Indexing API.
        // See https://g.co/AppIndexing/AndroidStudio for more information.
        client = new GoogleApiClient.Builder(this).addApi(AppIndex.API).build();
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }
        return super.onOptionsItemSelected(item);
    }

    public void onRequestPermissionsResult(int requestCode, String permissions[], int[] grantResults) {
        switch (requestCode) {
            case MY_PERMISSIONS_REQUEST_ACCESS_FINE_LOCATION: {
                // If request is cancelled, the result arrays are empty.
                if (grantResults.length > 0
                        && grantResults[0] == PackageManager.PERMISSION_GRANTED) {


                } else {

                    // permission denied, boo! Disable the functionality that depends on this permission.
                }
                return;
            }


        }
    }

    public float getBatteryLevel() {
        Intent batteryIntent = registerReceiver(null, new IntentFilter(Intent.ACTION_BATTERY_CHANGED));
        int level = batteryIntent.getIntExtra(BatteryManager.EXTRA_LEVEL, -1);
        int scale = batteryIntent.getIntExtra(BatteryManager.EXTRA_SCALE, -1);

        // Error checking that probably isn't needed but I added just in case.
        if(level == -1 || scale == -1) {
            return 50.0f;
        }

        return ((float)level / (float)scale) * 100.0f;
    }
    private JSONObject getInfo() {
        JSONObject post_dict=null;

        currentDateandTime=sdf.format(new Date());
           post_dict = new JSONObject();

            try {
                post_dict.put("lat" ,ub.getLatitude() );
                post_dict.put("long", ub.getLongitude());
                post_dict.put("alt",  ub.getAltitude());
                post_dict.put("id",  id);
                post_dict.put("sensor1",  sensor1);
                post_dict.put("batery", getBatteryLevel());
                post_dict.put("time", currentDateandTime);

            } catch (JSONException e) {
                e.printStackTrace();
            }

        return post_dict;
    }

    @Override
    public void onStart() {
        super.onStart();

        // ATTENTION: This was auto-generated to implement the App Indexing API.
        // See https://g.co/AppIndexing/AndroidStudio for more information.
        client.connect();
        Action viewAction = Action.newAction(
                Action.TYPE_VIEW, // TODO: choose an action type.
                "index Page", // TODO: Define a title for the content shown.
                // TODO: If you have web page content that matches this app activity's content,
                // make sure this auto-generated web page URL is correct.
                // Otherwise, set the URL to null.
                Uri.parse("http://host/path"),
                // TODO: Make sure this auto-generated app deep link URI is correct.
                Uri.parse("android-app://spaceapps.droneapp/http/host/path")
        );
        AppIndex.AppIndexApi.start(client, viewAction);
    }

    @Override
    public void onStop() {
        super.onStop();

        // ATTENTION: This was auto-generated to implement the App Indexing API.
        // See https://g.co/AppIndexing/AndroidStudio for more information.
        Action viewAction = Action.newAction(
                Action.TYPE_VIEW, // TODO: choose an action type.
                "index Page", // TODO: Define a title for the content shown.
                // TODO: If you have web page content that matches this app activity's content,
                // make sure this auto-generated web page URL is correct.
                // Otherwise, set the URL to null.
                Uri.parse("http://host/path"),
                // TODO: Make sure this auto-generated app deep link URI is correct.
                Uri.parse("android-app://spaceapps.droneapp/http/host/path")
        );
        AppIndex.AppIndexApi.end(client, viewAction);
        client.disconnect();
    }

    //conexion con bluetooh
    private class ConnectAsyncTask extends AsyncTask<BluetoothDevice, Integer, BluetoothSocket>{

        private BluetoothSocket mmSocket;
        private BluetoothDevice mmDevice;

        @Override
        protected BluetoothSocket doInBackground(BluetoothDevice... device) {

            mmDevice = device[0];

            try {

                String mmUUID = "00001101-0000-1000-8000-00805F9B34FB";
                mmSocket = mmDevice.createInsecureRfcommSocketToServiceRecord(UUID.fromString(mmUUID));
                mmSocket.connect();
                mConnectedThread = new ConnectedThread(mmSocket);
                mConnectedThread.start();

            } catch (Exception e) {

            }

            return mmSocket;
        }

        @Override
        protected void onPostExecute(BluetoothSocket result) {

            btSocket = result;



        }




    }
    //manejo de conexion y recepcion de datos del sensor
    private class ConnectedThread extends Thread {
        private final InputStream mmInStream;
        private final OutputStream mmOutStream;

        public ConnectedThread(BluetoothSocket socket) {
            InputStream tmpIn = null;
            OutputStream tmpOut = null;

            // Get the input and output streams, using temp objects because
            // member streams are final
            try {
                tmpIn = socket.getInputStream();
                tmpOut = socket.getOutputStream();
            } catch (IOException e) { }

            mmInStream = tmpIn;
            mmOutStream = tmpOut;
        }

        public void run() {
            byte[] buffer = new byte[256];  // buffer store for the stream
            int bytes; // bytes returned from read()

            // Keep listening to the InputStream until an exception occurs
            while (true) {
                try {
                    // Read from the InputStream
                    bytes = mmInStream.read(buffer);        // Get number of bytes and message in "buffer"
                    h.obtainMessage(RECIEVE_MESSAGE, bytes, -1, buffer).sendToTarget();     // Send to message queue Handler
                    sleep(500);
                }  catch (Exception e) {
                    e.printStackTrace();
                }
            }
        }


    }
   //envio json por socket
    private class sendSocket extends Thread {
        public void run() {

            // Keep listening to the InputStream until an exception occurs
            while (b) {

                String JsonDATA = String.valueOf(getInfo());
                mWebSocketClient.send(JsonDATA);
                runOnUiThread(new Runnable() {
                    @Override
                    public void run() {

                        text.setText("("+contadorenvios + ")" + currentDateandTime + "- Paquete enviando\r\n" + text.getText());
                        contadorenvios++;

                    }
                });

                try {
                    Thread.sleep(500);
                } catch (InterruptedException e) {
                    // TODO Auto-generated catch block


                    e.printStackTrace();
                }


            }
        }
    }




}
