<?php
ob_start();

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              Managepage.com
 * @since             1.0.0
 * @package           Manage_page
 *
 * @wordpress-plugin
 * Plugin Name:       Manage page
 * Plugin URI:        Managepage.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Chaitanya
 * Author URI:        Managepage.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       manage_page
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-manage_page-activator.php
 */
function activate_manage_page() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-manage_page-activator.php';
	Manage_page_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-manage_page-deactivator.php
 */
function deactivate_manage_page() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-manage_page-deactivator.php';
	Manage_page_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_manage_page' );
register_deactivation_hook( __FILE__, 'deactivate_manage_page' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-manage_page.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_manage_page() {

	$plugin = new Manage_page();
	$plugin->run();

}
run_manage_page();


add_action( 'wp_ajax_my_action', 'my_action' );
add_action( 'wp_ajax_my_products_edit', 'my_products_edit' );
add_action( 'wp_ajax_my_products_delete', 'my_products_delete' );

function my_action() {
  global $wpdb; // this is how you get access to the database

  $id = $_POST['id'];
  // echo "i m hre".
  $name = $_POST['name'];
  // die;
$sql="INSERT INTO googlefroms SET FormName = '$name' ";
  $results = $wpdb->get_results($sql);
  $fds=true;
  echo json_encode($fds);
  die;

  // wp_die(); // this is required to terminate immediately and return a proper response
}

function my_products_edit() {
	global $wpdb;
  $id = $_POST['id'];
	$sql="INSERT INTO googlefroms SET FormName = '$name' ";
  $results = $wpdb->get_results($sql);
  $fds=true;
  echo json_encode($fds);
  die;
}

function my_products_delete() {
	global $wpdb;
  $id = $_POST['id'];
	$sql="DELETE FROM wp_products where id=$id";
  $results = $wpdb->get_results($sql);
  $fds=true;
  echo json_encode($fds);
  die;
	// wp_redirect(admin_url('wp-admin/admin.php?page=example-options-3', 'http'), 301);
}

add_action("admin_menu","addMenu");
function addMenu(){
	add_menu_page("Example Options","Admin Ops",4,"admin-options","adminMenu");
	add_submenu_page("admin-options","Manage Pages","Manage Pages",4,"manage_page","websiteMenu");
	add_submenu_page("admin-options","Manage Questionnaire","Manage Questionnaire",4,"example-options-2","questionnaireMenu");
	add_submenu_page("admin-options","Manage Products","Manage Products",4,"productsMenu","productsMenu");
	add_submenu_page("admin-options","In-person testing","In-person testing",4,"example-options-4","testingMenu");
	add_submenu_page("admin-options","Google Forms","Google Forms",5,"example-options-5","googleforms");
}
function adminMenu(){
	echo "<br>";
	echo "Manage Website"."<br>";
	echo "Manage Questionnaire"."<br>";
	echo "Manage Products"."<br>";
	echo "In-person testing<br/>";
	echo "Google Forms";
}

function websiteMenu(){

	global $pagenow;
  if( $pagenow == 'admin.php' || isset( $_GET['post_type'] ) || $_GET['post_type'] == 'admin' ){
			wp_redirect(admin_url('/post.php?post=2&action=edit', 'http'), 301);
  }
}

function questionnaireMenu(){
  $postdata = $_POST;
  // print_r($postdata);
  if(is_array($postdata) && count($postdata))
  {
    echo "string";
    echo "<pre>";
    print_r($postdata);
    echo "</pre>";
  }

   get_header();
  global $wpdb;
  $sql="SELECT q.* , rf.risk_name  FROM `wp_questionnaire` q , `wp_risk_factors` rf Where q.risk_factor_id = rf.id and q.status = '1' ";
  $results = $wpdb->get_results($sql);

  if(!empty($results))
  {
    // get_header();
    ?>
      <!-- on click redirect page to questionaire -->
      <a href="http://localhost/alzheimer/al/add_question/"><button class="btn btn-primary">Add uestion</button></a> <br>
	     <br>

			<table border="2"  class="wp-list-table widefat fixed striped pages">
				<tr>
          <th>Sr No.</th>
					<th>Risk Factor</th>
					<th>Question</th>
					<th colspan="2">Action</th>
				</tr>

			<?php
      $counter="1";
			foreach($results as $row){
				?>
				<tr>
          <td align="center"><?php echo $counter; ?></td>
					<td align="center"><?php echo $row->risk_name; ?></td>
					<td align="center"><?php echo $row->question; ?></td>
					<td align="center"><button class="btn btn-xs btn-warning"><?php  ?>Edit</button></td>
					<td align="center"><button class="btn btn-xs btn-warning"><?php  ?>Delete</button></td>
				</tr>

				<?php
        $counter++;
  			}
				?>
			</table>
				<?php
				// get_footer();
  }
}

function productsMenu(){
	// get_header();
	if ( !function_exists( 'wp_delete_file' ) ) {
	   require_once ABSPATH . WPINC . '/functions.php';
	}

	// The path to the file to delete.
	// $file1 = '/uploads/2019/01/2.jpg';
	// $file = 'C:\xampp\htdocs\alzheimer\al\wp-content\uploads\2019\01\ait.png';
	// echo getcwd()."<br>";
	// echo content_url()."<br>";
	// echo get_home_path()."<br>";
	// echo $file."<br>";
	// echo $file1;
	// NOTICE! Understand what this does before running.
	// echo $result = wp_delete_file($file);


	// die;

	$postdata = $_POST;
	$product_image="";
	?>
		<?php
	if(is_array($postdata) && count($postdata)){
		global $wpdb;

		$productid = $_POST['productid'];
		$risk_factor_id = $_POST['risk_factor_id'];
		$productname = $_POST['productname'];
		$productinformation = $_POST['productinformation'];
		$productprice = $_POST['productprice'];
		$productmfgdate = $_POST['productmfgdate'];
		$productexpdate = $_POST['productexpdate'];
		if ( ! function_exists( 'wp_handle_upload' ) ) {
		    require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}
		if($_FILES['productimage']['size'] != 0){
			$uploadedfile = $_FILES['productimage'];
			$upload_overrides = array( 'test_form' => false );
			$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
			if ( $movefile && ! isset( $movefile['error'] ) ) {
					$productimage = $movefile['url'];
			} else {
					echo $movefile['error'];
			}
			$product_image.=" , photo='$productimage' ";

			if(isset($_POST['oldimage']))
			{
					 if ( ! function_exists( 'wp_handle_upload' ) ) {
			 		    require_once( ABSPATH . 'wp-admin/includes/file.php' );
			 		 }

					 $con=$_POST['oldimage'];
					 echo 	"rggdischtg". $con1=content_url()."/uploads/2019/01/1.jpg";
					 die;
					 $re=unlink($con1);
					 if($re){
						 echo 'alert("Deleted from file resource")';
					 }else{
						 echo 'alert("Not deleted from file resource")';
					 }
			}
		}
		else{
			$product_image.="";
		}

		if ($productid) {
		$update="UPDATE wp_products SET risk_factor_id='$risk_factor_id',product_name='$productname',information='$productinformation',price='$productprice',mfg_date='$productmfgdate',expiry_date='$productexpdate' ".$product_image." where id='$productid'";
			$results = $wpdb->get_results($update);
		} else {
			$insert="INSERT INTO wp_products(risk_factor_id,product_name,information,price,mfg_date,expiry_date,photo) VALUES('$risk_factor_id','$productname','$productinformation','$productprice','$productmfgdate','$productexpdate','$productimage')";
			$results = $wpdb->get_results($insert);
		}
	}
	global $wpdb;
	$sql="SELECT * FROM wp_products";
	$results = $wpdb->get_results($sql);

	if(!empty($results))
	{
		// get_header();
		?>
			<a href="<?php echo get_site_url()?>/add_products/"><button>Add New Product</button></a> <br>

			<br>
			<p class="search-box">
			<label class="screen-reader-text" for="post-search-input">Search Product</label>
			<input type="search" id="post-search-input" name="s" value="">
			<input type="submit" id="search-submit" class="button" value="Search Product"></p>
			<div class="table-responsive">
				<table class="wp-list-table widefat fixed striped pages">
						<tr>
							<th>Product Name</th>
							<th>Price</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>

				<?php

				foreach($results as $row){
					?>
						<tr>
							<td><?php echo $row->product_name; ?></td>
							<td><?php echo $row->price; ?></td>
							<td><a href="<?php echo get_site_url()?>/edit_products?id=<?php echo $row->id ?>"><button style="border:none;background-color:#f1f1f1;color:#444;">Edit</button></a></td>
							<td><button onclick='deleted(<?php echo $row->id;?>)' style="border:none;background-color:#f1f1f1;color:#444;">Delete</button></td>
						</tr>
					<?php
					}
					?>
				</table>
			</div>
				<?php
				// get_footer();
	}
	?>
	<script src="https://code.jquery.com/jquery-3.3.1.js" charset="utf-8"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" charset="utf-8"></script>
	<script type="text/javascript">
			// function edited(id){
			// 	var params = {id:id,action:"my_products_edit"};
			// 	jQuery.post(ajaxurl, params, function(response) {
			// 		// alert("Edited successfully");
			// 	});
			// }

			function deleted(id){
				// alert("inside deleted function"+id);
				var con=confirm("Do you want to delete this product?");
				if (con) {
					var params = {id:id,action:"my_products_delete"};
					jQuery.post(ajaxurl, params, function(response) {
						alert("Deleted successfully");
						window.location.href = "<?php echo get_site_url()?>/wp-admin/admin.php?page=productsMenu";
					});
				}
			}

	</script>
	<?php

}

function testingMenu(){
	echo "<br>";
	echo "testingMenu designs";
}

function googleforms()
{
  get_header();
	?>
	<button id="authorize_button" style="display: none;">Authorize</button>
    <button id="signout_button" style="display: none;">Sign Out</button>

    <div id="content" style="white-space: pre-wrap;"></div>

    <script  src="https://code.jquery.com/jquery-1.x-git.min.js"></script>
    <script type="text/javascript">
      // Client ID and API key from the Developer Console
      var CLIENT_ID = '39304712289-q93l4mtd877tnaqlfhgbqk2nnnd5829j.apps.googleusercontent.com';
      var API_KEY = 'AIzaSyA-IVzTcK1-qkiclGvbHzmIwdIs4cJQA5g';

      // Array of API discovery doc URLs for APIs used by the quickstart
      var DISCOVERY_DOCS = ["https://www.googleapis.com/discovery/v1/apis/drive/v3/rest"];

      // Authorization scopes required by the API; multiple scopes can be
      // included, separated by spaces.
      var SCOPES = 'https://www.googleapis.com/auth/drive.metadata.readonly';

      var authorizeButton = document.getElementById('authorize_button');
      var signoutButton = document.getElementById('signout_button');

      /**
       *  On load, called to load the auth2 library and API client library.
       */
      function handleClientLoad() {
        gapi.load('client:auth2', initClient);
      }

      /**
       *  Initializes the API client library and sets up sign-in state
       *  listeners.
       */
      function initClient() {
        gapi.client.init({
          apiKey: API_KEY,
          clientId: CLIENT_ID,
          discoveryDocs: DISCOVERY_DOCS,
          scope: SCOPES
        }).then(function () {
          // Listen for sign-in state changes.
          gapi.auth2.getAuthInstance().isSignedIn.listen(updateSigninStatus);

          // Handle the initial sign-in state.
          updateSigninStatus(gapi.auth2.getAuthInstance().isSignedIn.get());
          authorizeButton.onclick = handleAuthClick;
          signoutButton.onclick = handleSignoutClick;
        }, function(error) {
          appendPre(JSON.stringify(error, null, 2));
        });
      }

      /**
       *  Called when the signed in status changes, to update the UI
       *  appropriately. After a sign-in, the API is called.
       */
      function updateSigninStatus(isSignedIn) {
        if (isSignedIn) {
          authorizeButton.style.display = 'none';
          signoutButton.style.display = 'block';
          listFiles();
        } else {
          authorizeButton.style.display = 'block';
          signoutButton.style.display = 'none';
        }
      }

      /**
       *  Sign in the user upon button click.
       */
      function handleAuthClick(event) {
        gapi.auth2.getAuthInstance().signIn();
      }

      /**
       *  Sign out the user upon button click.
       */
      function handleSignoutClick(event) {
        // alert("vj")
        gapi.auth2.getAuthInstance().signOut();
      }

      /**
       * Append a pre element to the body containing the given message
       * as its text node. Used to display the results of the API call.
       *
       * @param {string} message Text to be placed in pre element.
       */
      function appendPre(message) {
        var pre = document.getElementById('content');
        var textContent = document.createTextNode(message + '\n');
        pre.appendChild(textContent);
      }

      /**
       * Print files.
       */
      function listFiles() {
      	var table="";
        gapi.client.drive.files.list({
          'pageSize': 1000,
          'fields': "nextPageToken, files(id, name, mimeType)"
        }).then(function(response) {
          // appendPre('Files:');
          var files = response.result.files;
          // console.log(files)
          if (files && files.length > 0) {
              table += "<table border='2'>";
              table+="<tr>";
              table+="<td>File Name</td>";
              table+="<td>File Id</td>";
              table+="<td colspan='2'>Upload</td>";
              table+="</tr>";
            for (var i = 0; i < files.length; i++) {
              var file = files[i];
              // console.log(file.mimeType);
              if(file.mimeType == "application/vnd.google-apps.form")
              {
                var a ="dd";
              	table+="<tr>";
              	table+="<td>"+file.name +"</td>";
              	table+="<td>"+file.id +"</td>";
              	table+="<td><a href='https://docs.google.com/forms/d/"+file.id +"/edit' target='_BLANK'>Check</td>";
              	table+="<td><button onclick='addtodb(\""+file.id+"\",\""+file.name+"\")'>Upload to db</button></td>";
              	table+="</tr>";

              }
            }
            table+="</table>";
          } else {
          	table+="No files found.";
          }
          // console.log(table);
            document.getElementById("content").innerHTML = table;
            // $('#content').html(table);
        });
      }

      function addtodb(id,name){
        var params = {id:id,name:name,action:"my_action"};
        // console.log(ajaxurl)
        jQuery.post(ajaxurl, params, function(response) {
          console.log(response);
		      alert('Got this from the server: ' + response);
		    });
      }


    </script>

    <script async defer src="https://apis.google.com/js/api.js"
      onload="this.onload=function(){};handleClientLoad()"
      onreadystatechange="if (this.readyState === 'complete') this.onload()">
    </script>
	<?php
}
?>
