<link href="<?php echo get_site_url() ?>/wp-includes/css/bootstrap4.min.css" rel="stylesheet" id="bootstrap-css">
<link href="<?php echo get_site_url() ?>/wp-includes/alzheimer_assets/css/jquery.dataTables.min.css" rel="stylesheet" id="bootstrap-css">
<?php
$sql="SELECT * FROM wp_products";
$results = $wpdb->get_results($sql);
if(!empty($results))
{
  ?>
  <table id="example" class="display" style="width:100%">
    <thead>
      <tr>
        <th>My column</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $frames=4;
      $total=count($results);
      $loops=ceil($total/$frames);
      for($i=1;$i<=$loops;$i++){
        echo "<tr>";
        $end=$i*$frames;
        $start= $end-4;

        for($j=$start;$j<$end;$j++){
          ?>
          <td><div style="border:1px black solid" class="col-3 float-left"><img  src="<?php echo $results[$j]->photo; ?>" width="150px"height="150px"><div><?php echo $results[$j]->product_name; ?></div></div></td>
          <?php
        }
        echo "</tr>";
      }
      ?>
    </tbody>
  </table>
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <!-- <script src="<?php echo get_site_url() ?>/wp-includes/alzheimer_assets/js/bootstrap4.min.js"></script> -->
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" charset="utf-8"></script>

  <script>
  $(document).ready(function() {
    $('#example').dataTable();
} )

</script>
<?php
}
?>
