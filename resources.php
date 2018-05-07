<?php

// database connection
function getDbConn() {
  $host = 'localhost'; // cuz in C9
  $dbname = 'local';
  $username = 'root';
  $password = 'root';
  
  $dbConn = new PDO("mysql:host=$host; dbname=$dbname", $username, $password);
  $dbConn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  return $dbConn;
}

// arrays
$categoryName = [];
$insurance = [];
$networking = [];
$training = [];

// get category names and types
$dbConn = getDbConn();

$sql = "SELECT categoryName, categoryType
        FROM r_category";
        
$stmt = $dbConn->prepare($sql);
$stmt->execute();

$records = $stmt -> fetchAll(PDO::FETCH_ASSOC);

// create category arrays
foreach($records as $r) {
  switch($r['categoryType']) {
      case 'Insurance':
          array_push($insurance, $r['categoryName']);
          break;
      case 'Networking':
          array_push($networking, $r['categoryName']);
          break;
      case 'Training':
          array_push($training, $r['categoryName']);
          break;
      default:
  }
}

// create category buttons
function makeSearch($arr, $type) {
  foreach($arr as $a) {
      echo '<a href="#" class= btn "' . $type . ' filter clicked">' . $a . '</a>';
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap 3 Lumen -->
    <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/lumen/bootstrap.min.css" rel="stylesheet" integrity="sha384-gv0oNvwnqzF6ULI9TVsSmnULNb3zasNysvWwfT/s4l8k5I+g6oFz9dye0wg3rQ2Q" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Smart Decisions</title>
</head>
<body>
    <!-- top area -->
    <section>
      <div class="container-fluid green">
        <div class="row">
          <div class="col-md-3">
            <img src="img/imageIcon.png" alt="Smart Decisions logo">
          </div>
          <div>

          </div>
        </div>
      </div>
    </section>
    
    <!-- navigation bar -->
    <nav class="navbar navbar-inverse">
      <!-- navigation -->
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Brand</a>
        </div>
    
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
          <ul class="nav navbar-nav">
            <li class="active">
              <a href="index.html">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li>
              <a href="about.html">About</a>
            </li>
            <li>
              <a href="services.html">Services</a>
            </li>
            <li>
              <a href="references.html">References</a>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li>
                  <a href="#">Action</a>
                </li>
                <li>
                  <a href="#">Another action</a>
                </li>
                <li>
                  <a href="#">Something else here</a>
                </li>
                <li class="divider"></li>
                <li>
                  <a href="#">Separated link</a>
                </li>
                <li class="divider"></li>
                <li>
                  <a href="#">One more separated link</a>
                </li>
              </ul>
            </li>
          </ul>
          <form class="navbar-form navbar-right" role="search">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Search">
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
          </form>
          <ul class="nav navbar-nav navbar-right">
            <li>
              <a href="#">Link</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- main -->
    <section>
      <div class="container">

        <!-- search bar -->
        <div class="row">
          <div class="col-lg-12">
            <form class="navbar-form navbar-left" role="search">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Enter a search term">
              </div>
              <button type="submit" id="searchSubmit" class="btn btn-primary">Submit</button>
              <button type="reset" class="btn btn-default">Clear</button>
            </form>
          </div>
        </div>

        <!-- search panels -->
        <div class="row">
          <div class="col-lg-4">
            <!-- insurance -->
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title">Insurance</h3>
                <label>
                  <input type="checkbox"> Check All
                </label>
              </div>
              <div class="panel-body">
                <?php makeSearch($insurance, 'insurance'); ?>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <!-- networking -->
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title">Networking</h3>
                <label>
                  <input type="checkbox"> Check All
                </label>
              </div>
              <div class="panel-body">
                <?php makeSearch($networking, 'networking'); ?>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <!-- training -->
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title">Training</h3>
                <label>
                  <input type="checkbox"> Check All
                </label>
              </div>
              <div class="panel-body">
                <?php makeSearch($training, 'training'); ?>
              </div>
            </div>
          </div>
        </div>

        <!-- results -->
        <div class="row">
          <div class="col-lg-12">
            <h2><span id="searchNum" class="badge">count</span>Search Results</h2>
            
            <!-- no results found message -->
            <div id="no-results" class="alert alert-dismissible alert-warning">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Sorry!</strong> No search results found. Please try changing your search criteria.
            </div>
            
            <!-- list of result items -->
            <div id="fillArea" class="container">
            </div>
          </div>
        </div>

      </div>
    </section>

    <!-- footer -->
    <section>
      <div class="footer">
        <div class="container-fluid indigo">
          <div class="container">
            <div class="row">
              <div class="col-md-1">
                  <a class="navbar-brand" href="#">Logo</a>
              </div>
              <div>

              </div>
    
            </div>
          </div>
        </div>
      </div>
    </section>

  
    <!-- jQuery CDN -->
    <script
        src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous">
    </script>
    
    <!-- javascript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!-- APIs and filtering search results -->
    <script>
      // get search results from database
      function searchResults(getData) {
        console.log(getData);
                
        // separate api data into tags and item info
        var items = getData[0];
        var tags = getData[1];
        var spanClass = '';
        
        if(items.length < 1) {
          // give warning message
          $('#no-results').show();
        } else {
          // hide warning message
          $('#no-results').hide();

          for(var i in items) {
            // make item boxes
            $('<div>')
              .appendTo('#fillArea')
              .attr('id', 'item' + items[i].itemId)
              .addClass('row itemBox')
              // add a small col for img/link
              .append(
                $('<div>')
                  .addClass('col-3')
                  // img with link
                  .append(
                    $('<a>')
                      .attr('href', items[i].itemLink)
                      .append(
                        $('<img>')
                          .attr('src', items[i].itemImage)
                          .attr('alt', items[i].itemName)
                      )
                  )
                  // link
                  .append(
                    $('<a>')
                      .attr('href', items[i].itemLink)
                      .addClass('btn btn-link')
                  )
              )
              //add title/description
              .append(
                $('<div>')
                  .addClass('col')
                  // title
                  .append(
                    $('<h3>').html(items[i].itemName)
                  )
                  // description
                  .append(
                    $('<p>').html(items[i].itemDescription)
                  )
              )
            ); // end of div rows
          }
          
          for(var t in tags) {

            switch(tags[t].categoryType) {
              case 'Insurance':
                spanClass = 'label-success';
                break;
              case 'Networking':
                spanClass = 'label-primary';
                break;
              case 'Training':
                spanClass = 'label-default';
                break;
              default:
                spanClass = 'label-info';
            }

            $('#item' + tags[t].itemId) + ' div h3')
              .append(
                $('<span>')
                  .addClass('label ' + spanClass + ' ' + tags[t].categoryType.toLowerCase())
                  .html(tags[t].categoryName)
              );          
          }
        
        }
      }      

      // create all search results
      function fillArea() {
        // make sure to not overlap existing search results list
        $('#fillArea').empty();

        // call for all table data
        $.ajax({

          type: "GET",
          url: "fill-api.php",
          dataType: "json",
          data: { },

          success: function(data, status) {
            searchResults(data);
          },

          complete: function(data, status) {
            // alert(status);
          }

        });
        
      };
        
      fillArea();

      // filter results based on search entry
      function searchText() {
        $('#fillArea').empty();

        console.log('submitted: ' + $('#searchText').val());
        
        var item = "";
        
        // input search bar value as item variable
        if($('#searchText').val() !== "") {
          item = 'item=' + $('#searchText').val();
        }
        
        $.ajax({
          type: "GET",
          url: "search-api.php?" + item,
          dataType: "json",
          data: { },
          
          success: function(data,status) {
            searchResults(data);
          }, // success
          
          complete: function(data,status) {
            // alert(status);
          } // complete 

        }); //ajax
      };

      $('#searchSubmit').click(searchText);

      // toggle search buttons to filter results
      $('.filter').click(function() {
        // set variables
        var tag = $(this).html();
        var cat = $(this).attr('class').split(' ')[0];
        
        // disabled = hidden; if currently disabled, change to show

        // check if btn is clicked
        if($(this).hasClass('disabled')) {
            $(this).removeClass('diabled');
            $('span.' + cat + ':contains("' + tag + '")').parents('.itemBox').show();
            
        } else { 
            $(this).addClass('disabled');
            $('span.' + cat + ':contains("' + tag + '")').parents('.itemBox').hide();
        }
        
        // usage of check all button
        if($('button.' + cat + '.disabled').length == 0) {
          // none disabled; all clicked
          $('#' + cat + 'CheckAll').prop('checked', true);
        } else if($('button.' + cat + '.disabled').length == $('button.' + cat).length) {
          // all disabled
          $('#' + cat + 'CheckAll').prop('checked', false);
        } {
          // some disabled, some clicked
          $('#' + cat + 'CheckAll').prop('checked', false);
        }
      };

    </script>

</body>
</html>