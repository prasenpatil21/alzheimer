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

add_action('admin_menu', 'my_plugin_menu');

function my_plugin_menu() {
  add_plugins_page('Plugin Page', 'Risk Factors', 'read', 'riskfactors', 'riskfactors');
  add_plugins_page('Plugin Page', 'Grade Percentage', 'read', 'gradepercentage', 'gradepercentage');
  add_plugins_page('Plugin Page', 'In Person Testing', 'read', 'addinpersontesting', 'addinpersontesting');
  add_plugins_page('Plugin Page', 'Grade Product Mapping', 'read', 'gradeproductmapping', 'gradeproductmapping');
}

add_action( 'wp_ajax_my_action', 'my_action' );
add_action( 'wp_ajax_my_products_edit', 'my_products_edit' );
add_action( 'wp_ajax_my_products_delete', 'my_products_delete' );
add_action( 'wp_ajax_my_question_delete', 'my_question_delete' );
add_action( 'wp_ajax_my_riskfactor_delete', 'my_riskfactor_delete' );
add_action( 'wp_ajax_my_gradepercentage_delete', 'my_gradepercentage_delete' );
add_action( 'wp_ajax_my_gradeproductmapping_delete', 'my_gradeproductmapping_delete' );

function my_action() {
  global $wpdb; // this is how you get access to the database

  $GoogleId = $_POST['id'];
  // echo "i m hre".
  $FormName = $_POST['name'];
  // die;
  $check = "SELECT Id FROM googlefroms WHERE GoogleId = '$GoogleId' AND Status = '1' ";
  $rescheck = $wpdb->get_results($check);
  if(is_array($rescheck) && count($rescheck))
  {
    $fds=true;
  }
  else
  {
    $sql="INSERT INTO googlefroms SET FormName = '$FormName',  GoogleId = '$GoogleId' , Status = '1' ";
    $results = $wpdb->get_results($sql);
    $fds=true;
  }
  
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

function my_question_delete() {
  global $wpdb;
  $id = $_POST['id'];
  $sql="UPDATE  wp_questionnaire SET status ='0'  where id=$id";
  $results = $wpdb->get_results($sql);
  $response=true;
  echo json_encode($response);
  die;
  // wp_redirect(admin_url('wp-admin/admin.php?page=example-options-3', 'http'), 301);
}

function my_riskfactor_delete() {
  global $wpdb;
  $id = $_POST['id'];
  $sql="UPDATE  wp_risk_factors SET status ='0'  where id=$id";
  $results = $wpdb->get_results($sql);
  $response=true;
  echo json_encode($response);
  die;
  // wp_redirect(admin_url('wp-admin/admin.php?page=example-options-3', 'http'), 301);
}

function my_gradepercentage_delete() {
  global $wpdb;
  $id = $_POST['id'];
  $sql="UPDATE  wp_user_grade SET status ='0'  where id=$id";
  $results = $wpdb->get_results($sql);
  $response=true;
  echo json_encode($response);
  die;
  // wp_redirect(admin_url('wp-admin/admin.php?page=example-options-3', 'http'), 301);
}

function my_gradeproductmapping_delete() {
	global $wpdb;
  $id = $_POST['id'];
	$sql="UPDATE  `wp-grade_products_mapping` SET status ='0'  where id=$id";
  $results = $wpdb->get_results($sql);
  $response=true;
  echo json_encode($response);
  die;
	// wp_redirect(admin_url('wp-admin/admin.php?page=example-options-3', 'http'), 301);
}

add_action("admin_menu","addMenu");
function addMenu(){
	add_menu_page("Example Options","Admin Ops",4,"admin-options","adminMenu");
	add_submenu_page("admin-options","Manage Pages","Manage Pages",4,"manage_page","websiteMenu");
	add_submenu_page("admin-options","Manage Questionnaire","Manage Questionnaire",4,"managequestions","questionnaireMenu");
	add_submenu_page("admin-options","Manage Products","Manage Products",4,"example-options-3","productsMenu");
	add_submenu_page("admin-options","In-person testing","In-person testing",4,"inpersontesting","testingMenu");
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

function riskfactors()
{
   global $wpdb;
  $postdata = $_POST;
  // print_r($postdata);
  if(is_array($postdata) && count($postdata))
  {
      if($postdata['type']=="add")
      {
        $risk_name = $postdata['risk_name'];
        $information = $postdata['information'];
        $date = date("Y-m-d");
        $insert="INSERT INTO wp_risk_factors SET risk_name ='$risk_name' , information = '$information' , status = '1' , created_on = '$date' ";
        $res = $wpdb->get_results($insert);
        echo "Added Successfully !!";
      }
      else
        if($postdata['type']=="update")
        {
            $risk_name = $postdata['risk_name'];
            $information = $postdata['information'];
            $rfid = $postdata['rfid'];
            $insert="UPDATE  wp_risk_factors SET risk_name ='$risk_name' , information = '$information' , status = '1' WHERE id = '$rfid' ";
            $res = $wpdb->get_results($insert);
            echo "Updated Successfully !!";
        }
  }
   get_header();
    $sql="SELECT * FROM  `wp_risk_factors` Where status = '1' ";
    $results = $wpdb->get_results($sql);
    
    if(!empty($results))
    {
      ?>
        <!-- on click redirect page to questionaire -->
        <a href="<?php echo get_site_url()?>/addriskfactor/"><button class="btn btn-primary">Add Risk Factor</button></a>
        <a href="<?php echo get_site_url()?>/wp-admin/admin.php?page=managequestions"><button class="btn btn-primary">Manage Questions</button></a>
         <br>
         <br>

        <table border="2"  class="table table-striped">
          <tr>
            <th>Sr No.</th>
            <th>Risk Factor</th>
            <th>Information</th>
            <th colspan="2">Action</th>
          </tr>

        <?php
        $counter="1";
        foreach($results as $row){
          ?>
          <tr>
            <td align="center"><?php echo $counter; ?></td>
            <td align="center"><?php echo $row->risk_name; ?></td>
            <td align="center"><?php echo $row->information; ?></td>
            <td align="center"> <a href="<?php echo get_site_url()?>/addriskfactor?id=<?php echo $row->id; ?>"><button class="btn btn-xs btn-warning"><?php  ?>Edit</button></a></td>
            <td align="center"><button class="btn btn-xs btn-warning" onclick="deleteriskfactor(<?php echo $row->id ?>)" ><?php  ?>Delete</button></td>
          </tr>

          <?php
          $counter++;
          }
          ?>
        </table>
        <script type="text/javascript">
        function deleteriskfactor(id){
          var check =confirm("Are you sure to delete selected Grade Percentage ? ");
          if(check==true){
            // alert("inside deleted function"+id);
            var params = {id:id,action:"my_riskfactor_delete"};
            jQuery.post(ajaxurl, params, function(response) {
              if(response)
                {
                  var checkres = confirm("Deleted Successfully !!");
                  if(checkres==true)
                  {
                    window.location.href = "<?php echo get_site_url()?>/wp-admin/admin.php?page=riskfactors";
                  }
                  else
                  {
                    window.location.href = "<?php echo get_site_url()?>/wp-admin/admin.php?page=riskfactors";
                  } 
                }
            });
          }

        }</script>
          <?php
          // get_footer();
    }
}

  
function gradeproductmapping()
{
   global $wpdb;
   get_header();
  $postdata = $_POST;
  ?>
  <br style="clear: both;" />
  <br style="clear: both;" />
  <a href="<?php echo get_site_url()?>/addproductgrademapping/"><button class="btn btn-primary">Add Grade Product Mapping</button></a>
  <?php
  if(is_array($postdata) && count($postdata))
  {
    if($postdata['type']=="add")
    {
      $Arrgrade_id = $postdata['grade_id'];
      $expgrade_id = explode(",", $Arrgrade_id);
      $grade_id = $expgrade_id[0];
      $risk_factor_id = $expgrade_id[1];
      $Arrproduct_id = $postdata['product_id'];

       for ($i=0; $i <count($Arrproduct_id) ; $i++) { 
          $product_id = $Arrproduct_id[$i];
          $checkAlready = "SELECT id FROM `wp-grade_products_mapping` WHERE grade_id = '$grade_id' AND risk_factor_id = '$risk_factor_id' AND product_id = '$product_id' AND status = '1'";
          $Checkres = $wpdb->get_results($checkAlready);
          if(is_array($Checkres) && count($Checkres))
          {}
          else
          {
           $insert = "INSERT INTO `wp-grade_products_mapping` SET grade_id = '$grade_id' , risk_factor_id = '$risk_factor_id' , product_id = '$product_id' , status = '1' ";
            $res = $wpdb->get_results($insert);
          }
      }
      echo "Added Successfully !!";
    }
    else
    if($postdata['type']=="update")
    {
        $Mapping_id = $postdata['mapping_id'];
        $Arrgrade_id = $postdata['grade_id'];
      $expgrade_id = explode(",", $Arrgrade_id);
      $grade_id = $expgrade_id[0];
      $risk_factor_id = $expgrade_id[1];
      $product_id = $postdata['product_id'];
        $insert="UPDATE  `wp-grade_products_mapping` SET risk_factor_id ='$risk_factor_id' , grade_id = '$grade_id' , product_id = '$product_id' , status = '1' WHERE id = '$Mapping_id'  ";
        $res = $wpdb->get_results($insert);
        echo "Updated Successfully !!";
    }
  }
   $sql="SELECT gp.id , rf.risk_name , p.product_name , g.grade_name FROM `wp-grade_products_mapping` gp , `wp_user_grade` g , `wp_risk_factors` rf , wp_products p Where gp.risk_factor_id = rf.id and gp.status = '1' AND gp.grade_id = g.id ANd gp.product_id = p.id ";
   $results = $wpdb->get_results($sql);
    
    if(!empty($results))
    {
      ?>
        <!-- on click redirect page to questionaire -->
         <br>
         <br>

        <table border="2"  class="table table-striped">
          <tr>
            <th>Sr No.</th>
            <th>Risk Factor</th>
            <th>Grade</th>
            <th>Product</th>
            <th colspan="2">Action</th>
          </tr>

        <?php
        $counter="1";
        foreach($results as $row){
          ?>
          <tr>
            <td align="center"><?php echo $counter; ?></td>
            <td align="center"><?php echo $row->risk_name; ?></td>
            <td align="center"><?php echo $row->grade_name; ?></td>
            <td align="center"><?php echo $row->product_name; ?></td>
            <td align="center"> <a href="<?php echo get_site_url()?>/addproductgrademapping?id=<?php echo $row->id; ?>"><button class="btn btn-xs btn-warning"><?php  ?>Edit</button></a></td>
            <td align="center"><button class="btn btn-xs btn-warning" onclick="deletegradeproductmapping(<?php echo $row->id ?>)" ><?php  ?>Delete</button></td>
          </tr>

          <?php
          $counter++;
          }
          ?>
        </table>
        <script type="text/javascript">
        function deletegradeproductmapping(id){
          var check =confirm("Are you sure to delete selected Mapping ? ");
          if(check==true){
            // alert("inside deleted function"+id);
            var params = {id:id,action:"my_gradeproductmapping_delete"};
            jQuery.post(ajaxurl, params, function(response) {
              if(response)
                {
                  var checkres = confirm("Deleted Successfully !!");
                  if(checkres==true)
                  {
                    window.location.href = "<?php echo get_site_url()?>/wp-admin/admin.php?page=gradeproductmapping";
                  }
                  else
                  {
                    window.location.href = "<?php echo get_site_url()?>/wp-admin/admin.php?page=gradeproductmapping";
                  } 
                }
            });
          }

        }</script>
          <?php
          // get_footer();
    }
}

function gradepercentage()
{
   global $wpdb;
  $postdata = $_POST;
  if(is_array($postdata) && count($postdata))
  {
      if($postdata['type']=="add")
      {
        $risk_factor_id = $postdata['risk_factor_id'];
        $grade_name = $postdata['grade_name'];
        $grade_details = $postdata['grade_details'];
        $upper_limit = $postdata['upper_limit'];
        $lower_limit = $postdata['lower_limit'];
        $insert="INSERT INTO wp_user_grade SET risk_factor_id ='$risk_factor_id' , grade_name = '$grade_name' , upper_limit = '$upper_limit' , lower_limit = '$lower_limit' , grade_details = '$grade_details' , status = '1'  ";
        $res = $wpdb->get_results($insert);
        echo "Added Successfully !!";
      }
      else
        if($postdata['type']=="update")
        {
            $gpid = $postdata['gpid'];
            $risk_factor_id = $postdata['risk_factor_id'];
            $grade_name = $postdata['grade_name'];
            $grade_details = $postdata['grade_details'];
            $upper_limit = $postdata['upper_limit'];
            $lower_limit = $postdata['lower_limit'];
            $insert="UPDATE  wp_user_grade SET risk_factor_id ='$risk_factor_id' , grade_name = '$grade_name' , upper_limit = '$upper_limit' , lower_limit = '$lower_limit' , grade_details = '$grade_details' , status = '1' WHERE id = '$gpid'  ";
            $res = $wpdb->get_results($insert);
            echo "Updated Successfully !!";
        }
  }
   get_header();
    $sql="SELECT g.* , rf.risk_name  FROM `wp_user_grade` g , `wp_risk_factors` rf Where g.risk_factor_id = rf.id and g.status = '1' ";
   $results = $wpdb->get_results($sql);
    
    if(!empty($results))
    {
      ?>
        <!-- on click redirect page to questionaire -->
        <a href="<?php echo get_site_url()?>/addgradepercentage/"><button class="btn btn-primary">Add Grade Percentage</button></a>
        <a href="<?php echo get_site_url()?>/wp-admin/admin.php?page=managequestions"><button class="btn btn-primary">Manage Questions</button></a>
         <br>
         <br>

        <table border="2"  class="table table-striped">
          <tr>
            <th>Sr No.</th>
            <th>Risk Factor</th>
            <th>Grade</th>
            <th>Deatils</th>
            <th>Upper Limit</th>
            <th>Lower Limit</th>
            <th colspan="2">Action</th>
          </tr>

        <?php
        $counter="1";
        foreach($results as $row){
          ?>
          <tr>
            <td align="center"><?php echo $counter; ?></td>
            <td align="center"><?php echo $row->risk_name; ?></td>
            <td align="center"><?php echo $row->grade_name; ?></td>
            <td align="center"><?php echo $row->grade_details; ?></td>
            <td align="center"><?php echo $row->upper_limit; ?></td>
            <td align="center"><?php echo $row->lower_limit; ?></td>
            <td align="center"> <a href="<?php echo get_site_url()?>/addgradepercentage?id=<?php echo $row->id; ?>"><button class="btn btn-xs btn-warning"><?php  ?>Edit</button></a></td>
            <td align="center"><button class="btn btn-xs btn-warning" onclick="deletegradepercentage(<?php echo $row->id ?>)" ><?php  ?>Delete</button></td>
          </tr>

          <?php
          $counter++;
          }
          ?>
        </table>
        <script type="text/javascript">
        function deletegradepercentage(id){
          var check =confirm("Are you sure to delete selected Risk Factor ? ");
          if(check==true){
            // alert("inside deleted function"+id);
            var params = {id:id,action:"my_gradepercentage_delete"};
            jQuery.post(ajaxurl, params, function(response) {
              if(response)
                {
                  var checkres = confirm("Deleted Successfully !!");
                  if(checkres==true)
                  {
                    window.location.href = "<?php echo get_site_url()?>/wp-admin/admin.php?page=gradepercentage";
                  }
                  else
                  {
                    window.location.href = "<?php echo get_site_url()?>/wp-admin/admin.php?page=gradepercentage";
                  } 
                }
            });
          }

        }</script>
          <?php
          // get_footer();
    }
}





function websiteMenu(){

	global $pagenow;
  if( $pagenow == 'admin.php' || isset( $_GET['post_type'] ) || $_GET['post_type'] == 'admin' ){
			wp_redirect(admin_url('/post.php?post=2&action=edit', 'http'), 301);
  }
}

function questionnaireMenu(){
  global $wpdb;
  $postdata = $_POST;
  // print_r($postdata);
  if(is_array($postdata) && count($postdata))
  {
    if($postdata['type']=="add")
    {
      $risk_factor_id = $postdata['risk_factor_id'];
      $question = $postdata['question'];
      $score = $postdata['score'];
      $option = $postdata['option'];
      $date = date("Y-m-d");
      $insert="INSERT INTO wp_questionnaire SET risk_factor_id ='$risk_factor_id' , question = '$question' , status = '1' , created_on = '$date' ";
      $res = $wpdb->get_results($insert);
      $get_last_id = "SELECT LAST_INSERT_ID() AS lastid ";
      $res_last_id = $wpdb->get_results($get_last_id);
      
      $last_id = $res_last_id[0]->lastid; 
      for ($i=0; $i <count($score) ; $i++) { 
          $current_score = $score[$i];
          $current_option = $option[$i];
          $insert_options = "INSERT INTO wp_custom_options SET question_id = '$last_id' , options = '$current_option' , score = '$current_score' , status = '1' ";
          $res = $wpdb->get_results($insert_options);
      }
      echo "Added Successfully !!";
    }
    else
      if($postdata['type']=="update")
      {
          $risk_factor_id = $postdata['risk_factor_id'];
          $question_id = $postdata['question_id'];
          $question = $postdata['question'];
          $score = $postdata['score'];
          $option = $postdata['option'];
          $date = date("Y-m-d");
          $insert="UPDATE  wp_questionnaire SET risk_factor_id ='$risk_factor_id' , question = '$question' , status = '1' WHERE id = '$question_id' ";
          $res = $wpdb->get_results($insert);
         if($score[0]!="")
         {
            for ($i=0; $i <count($score) ; $i++) { 
                $current_score = $score[$i];
                $current_option = $option[$i];
                if(($current_score!="") && ($current_option!="") )
                {
                  $insert_options = "INSERT INTO wp_custom_options SET question_id = '$question_id' , options = '$current_option' , score = '$current_score' , status = '1' ";
                  $res = $wpdb->get_results($insert_options);
                }
            }
         }
          echo "Updated Successfully !!";
      }
  }
  
   get_header();
  $sql="SELECT q.* , rf.risk_name  FROM `wp_questionnaire` q , `wp_risk_factors` rf Where q.risk_factor_id = rf.id and q.status = '1' ";
  $results = $wpdb->get_results($sql);

  if(!empty($results))
  {
    // get_header();
    ?>
      <!-- on click redirect page to questionaire -->
      <a href="<?php echo get_site_url()?>/add_question/"><button class="btn btn-primary">Add Question</button></a>
      <a href="<?php echo get_site_url()?>/wp-admin/admin.php?page=riskfactors"><button class="btn btn-primary">Risk Factors</button></a> 
      <a href="<?php echo get_site_url()?>/wp-admin/admin.php?page=gradepercentage"><button class="btn btn-primary">Grade Percentage</button></a> <br>
	     <br>

			<table border="2"  class="table table-striped">
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
					<td align="center"> <a href="<?php echo get_site_url()?>/add_question?id=<?php echo $row->id; ?>"><button class="btn btn-xs btn-warning"><?php  ?>Edit</button></a></td>
					<td align="center"><button class="btn btn-xs btn-warning" onclick="deletequestion(<?php echo $row->id ?>)" ><?php  ?>Delete</button></td>
				</tr>

				<?php
        $counter++;
  			}
				?>
			</table>
      <script type="text/javascript">
      function deletequestion(id){
        var check =confirm("Are you sure to delete selected question ? ");
        if(check==true){
          // alert("inside deleted function"+id);
          var params = {id:id,action:"my_question_delete"};
          jQuery.post(ajaxurl, params, function(response) {
            if(response)
              {
                var checkres = confirm("Deleted Successfully !!");
                if(checkres==true)
                {
                  window.location.href = "<?php echo get_site_url()?>/wp-admin/admin.php?page=managequestions";
                }
                else
                {
                  window.location.href = "<?php echo get_site_url()?>/wp-admin/admin.php?page=managequestions";
                } 
              }
          });
        }

      }</script>
				<?php
				// get_footer();
  }
}

function productsMenu(){
  if ( !function_exists( 'wp_delete_file' ) ) { 
    require_once ABSPATH . WPINC . '/functions.php'; 
} 
  
// The path to the file to delete. 
$file = ''; 
  
// NOTICE! Understand what this does before running. 
$result = wp_delete_file($file); 

die;
	echo "<br>";
	global $wpdb;
	$sql="SELECT * FROM wp_products";
	$results = $wpdb->get_results($sql);

	if(!empty($results))
	{
		// get_header();
		?>
			<!-- on click redirect page to questionaire -->
			<a href="<?php echo get_site_url()?>/add_question/"><button>Click here</button></a> <br>

			<table border="2" style="width:100%;">
				<tr>
					<th>Category</th>
					<th>Product Name</th>
					<th>Price</th>
					<th colspan="2">Action</th>
				</tr>

			<?php

			foreach($results as $row){
				?>
				<tr>
					<td align="center"><?php echo $row->category; ?></td>
					<td align="center"><?php echo $row->product_name; ?></td>
					<td align="center"><?php echo $row->price; ?></td>
					<td align="center"><button onclick='edited(<?php echo $row->id;?>)' style="border:none;background-color:#f1f1f1;color:#444;">Edit</button></td>
					<td align="center"><button onclick='deleted(<?php echo $row->id;?>)' style="border:none;background-color:#f1f1f1;color:#444;">Delete</button></td>
				</tr>

				<?php
				}
				?>
			</table>
				<?php
				// get_footer();
	}
	?>
	<script type="text/javascript">
			function edited(id){
				// alert("inside edited function"+id);
				// console.log("console of edited");
				var params = {id:id,action:"my_products_edit"};
				jQuery.post(ajaxurl, params, function(response) {
					console.log("edited"+response);
				});
			}

			function deleted(id){
				// alert("inside deleted function"+id);
				var params = {id:id,action:"my_products_delete"};
				jQuery.post(ajaxurl, params, function(response) {
					console.log("deleted:"+response);
				});

			}
	</script>
	<?php


}

function testingMenu(){
    global $wpdb;
  get_header();
  $sql="SELECT * FROM `googlefroms`  Where Status = '1' ";
  $results = $wpdb->get_results($sql);
  ?>
  <a href="<?php echo get_site_url()?>/wp-admin/admin.php?page=addinpersontesting"><button class="btn btn-primary">Add Test</button></a>
  <?php
  if(!empty($results))
  {
    // get_header();
    ?>
      <!-- on click redirect page to questionaire -->
      <!-- <a href="<?php echo get_site_url()?>/wp-admin/admin.php?page=riskfactors"><button class="btn btn-primary">Risk Factors</button></a>  -->
      <!-- <a href="<?php echo get_site_url()?>/wp-admin/admin.php?page=gradepercentage"><button class="btn btn-primary">Grade Percentage</button></a> <br> -->
       <br>
       <br>

      <table border="2"  class="table table-striped">
        <tr>
          <th>Sr No.</th>
          <th>Form Name</th>
          <th colspan="3">Action</th>
        </tr>

      <?php
      $counter="1";
      foreach($results as $row){
        ?>
        <tr>
          <td align="center"><?php echo $counter; ?></td>
          <td align="center"><?php echo $row->FormName; ?></td>
          <td align="center"> <a <a href='https://docs.google.com/forms/d/<?php echo $row->GoogleId ?>/viewform'  target="_BLANK"><button class="btn btn-xs btn-warning"><?php  ?>Take Test</button></a></td>
          <td align="center"> <a <a href='https://docs.google.com/forms/d/<?php echo $row->GoogleId ?>/edit' target="_BLANK"><button class="btn btn-xs btn-warning"><?php  ?>Edit</button></a></td>
          <td align="center"><button class="btn btn-xs btn-warning" onclick="deletequestion(<?php echo $row->id ?>)" ><?php  ?>Delete</button></td>
        </tr>

        <?php
        $counter++;
        }
        ?>
      </table>
      <?php
  }
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

function addinpersontesting()
{
  get_header();
  ?>
  <button id="authorize_button" class="btn btn-primary" style="display: none;">Authorize</button>
    <button id="signout_button" class="btn btn-primary" style="display: none;">Sign Out</button>
    <a href="https://docs.google.com/forms/u/0/?tgif=d" target="_BLANK"><button class="btn btn-primary" >Create New</button> </a>
  <br/>

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
              table += "<table border='2' class='table table-striped'>";
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
                table+="<tr>";
                table+="<td>"+file.name +"</td>";
                table+="<td>"+file.id +"</td>";
                table+="<td><a href='https://docs.google.com/forms/d/"+file.id +"/edit' target='_BLANK'>Check</td>";
                table+="<td><button  class='btn btn-warning' onclick='addtodb(\""+file.id+"\",\""+file.name+"\")'>Upload to db</button></td>";
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
          alert('Test Added To Application. Please Lead to All Tests . ');
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
