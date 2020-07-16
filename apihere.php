<html lang="en">

<?php
    session_start();
   
    if(!isset($_SESSION['username'])){
        header("Location: index.php");
    }
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">

    <script src="https://js.api.here.com/v3/3.1/mapsjs-core.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-service.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js" type="text/javascript" charset="utf-8"></script>

    <script src="https://js.api.here.com/v3/3.1/mapsjs-ui.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="http://js.api.here.com/v3/3.1/mapsjs-ui.css" />

    <style type="text/css">
        body {
          background-size: cover;
        }
        #box1 {
          height: 40px;
          width: 300px;
          margin-top: 50px;
        }
        #box2 {
          height: 40px;
          width: 300px;
          margin-top: 20px;
        }
        a {
            color: white;
        }
        a.hover {
            text-decoration-line: none;
        }
        @media only screen and (max-width: 400px) {
            .container-cover {
                position: relative;
                 margin-top: 30px;
            }
        }
        @media only screen and (min-width: 770px) {
            #box1 {
                margin-top: 150px;
            }
        }
    </style>

</head>

<body>
    <nav class="navbar bg-dark fixed-top" style="color: white">
        <div class="container-fluid">
            <div class="nav navbar-nav">You are now Logged in!</div>
            <div class="nav navbar-nav content-end"><a href="signout.php?logout=1">Logout</a></div>
        </div>
    </nav>
    <div class="container-cover"  style="position: relative; padding-bottom: 0px ; height: 100%">
      <div class="row" style="height: 100%">
      <div class="col-12 col-md-5" style="background-color: #3A3838; color: white">
        <form method="POST" action=""  name="myform">
        
        <center>
            <p><input type="text" class="form-control rounded-pill  border border-success" placeholder="Enter starting point" required name="Location1" id="box1"></input></p>
            <p><input type="text" class="form-control rounded-pill  border border-success" placeholder="Enter destination" required name="Location2" id="box2"></input></p>
        
            <p><button type="submit" name="submit" class="btn-outline-success btn-toggle btn-large btn-block rounded-pill" id="box2"><strong>Display route</strong></button>
        </p></center>
            
      </form>
    </div>

    <div class="col-12 col-md-7 w-100" id="map">
    <script>

        var mapContainer = document.getElementById('map'),
            routeInstructionsContainer = document.getElementById('panel');

        var platform = new H.service.Platform({
            'apikey': 'j3O91_2BF0WCbCoukoosfv4PY4FumozY3Q0j6TdeVtI'
        });

        var defaultLayers = platform.createDefaultLayers();

        var map = new H.Map(mapContainer,
            defaultLayers.vector.normal.map, {
                center: {
                    lat: 28.644800,
                    lng: 77.216721
                },
                zoom: 13,
                pixelRatio: window.devicePixelRatio || 1
            });

        var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));
        var ui = H.ui.UI.createDefault(map, defaultLayers);
        
        
        if("<?php echo isset($_POST['submit']); ?>") {
        function calculateRouteFromAtoB(platform, pos) {
            console.log(pos);
            console.log(pos.length);
            var router = platform.getRoutingService(),
                routeRequestParams = {
                    mode: 'fastest;car',
                    representation: 'display',
                    routeattributes: 'waypoints,summary,shape,legs',
                    maneuverattributes: 'direction,action',
                    waypoint0: `${pos[0].lat},${pos[0].lng}`, // Brandenburg Gate
                    waypoint1: `${pos[1].lat},${pos[1].lng}` // Friedrichstraße Railway Station
                };

            router.calculateRoute(
                routeRequestParams,
                onSuccess,
                onError
            );
        }
        function addRouteShapeToMap(route) {
            var lineString = new H.geo.LineString(),
                routeShape = route.shape,
                polyline;

            routeShape.forEach(function(point) {
                var parts = point.split(',');
                lineString.pushLatLngAlt(parts[0], parts[1]);
            });

            polyline = new H.map.Polyline(lineString, {
                style: {
                    lineWidth: 4,
                    strokeColor: 'rgba(0, 128, 255, 0.7)'
                }
            });

            map.addObject(polyline);
            map.getViewModel().setLookAtData({
                bounds: polyline.getBoundingBox()
            });
        }


        function onError(error) {
            alert('Can\'t reach the remote server');
        }

        

        var geocodingParams = {
            searchText: '<?php if(isset($_POST["submit"])){echo $_POST["Location1"] ;} ?>'
        };

        var geocodingParams1 = {
            searchText: '<?php if(isset($_POST["submit"])){echo $_POST["Location2"] ;} ?>'
        };

        obj = Object({
            'arr': Array()
        });
        function onSuccess(result) {
            var route = result.response.route[0];
            addRouteShapeToMap(route);
           // addManueversToMap(route);

            //addWaypointsToPanel(route.waypoint);
            //addManueversToPanel(route);
            //addSummaryToPanel(route.summary);
        }
        var onResult = function(result) {
            var locations = result.Response.View[0].Result,
                position,
                marker;

            for (i = 0; i < locations.length; i++) {
                position = {
                    lat: locations[i].Location.DisplayPosition.Latitude,
                    lng: locations[i].Location.DisplayPosition.Longitude
                };
                obj['arr'].push(position);

                map.setCenter(position);
                map.setZoom(10);
                marker = new H.map.Marker(position);
                map.addObject(marker);
            }
        };

        window.addEventListener('resize', () => map.getViewPort().resize());
        var geocoder = platform.getGeocodingService();

       
            geocoder.geocode(geocodingParams, onResult, function(e) {
                alert(e);
            }).then(function() {
                
                geocoder.geocode(geocodingParams1, onResult, function(e) {
                    alert(e);
                }).then(function(){
                    calculateRouteFromAtoB(platform, obj['arr']);
                });
            });
        }
        
    

    </script>
</div>
    <script src="jquery.min.js"></script>
    <script src="popper.min.js"></script>
    <script src="bootstrap/bootstrap.min.js"></script>
</body>

</html>
