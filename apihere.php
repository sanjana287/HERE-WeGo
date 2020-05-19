<html lang="en">

<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <meta name="viewport" content="initial-scale=1.0, width=device-width" />
    <script src="https://js.api.here.com/v3/3.1/mapsjs-core.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-service.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js" type="text/javascript" charset="utf-8"></script>

    <meta name="viewport" content="initial-scale=1.0,
        width=device-width" />
    <script src="https://js.api.here.com/v3/3.1/mapsjs-ui.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-service.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="http://js.api.here.com/v3/3.1/mapsjs-ui.css" />


    <style type="text/css">
    	body {
          background-size: cover;
    	}
      	#box1 {
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
    </style>

</head>

<body>
        <nav class="navbar bg-dark fixed-top" style="color: white">
      <div class="container-fluid">
        <div class="nav navbar-nav">Username</div>
        <div class="nav navbar-nav content-end"><a href="SCROLL.html">Logout</a></div>
      </div>
    </nav>
    <div class="container-cover"  style="position: relative; margin-top: 4%; padding-bottom: 0px ; height: 100%">
      <div class="row" style="height: 100%">
      <div class="col-sm-3" style="background-color: #3A3838; color: white">
	    <form method="POST" action="" style=" padding-left: 4%" name="myform">
        
        <center>
	    	<p><input type="text" class="form-control rounded-pill  border border-success" placeholder="Enter starting point" required name="Location1" id="box1" style="margin-top: 30%"></input></p>
	    	<p><input type="text" class="form-control rounded-pill  border border-success" placeholder="Enter destination" required name="Location2" id="box1"></input></p>
        
	    	<p><button type="submit" name="submit" class="btn-outline-success btn-toggle btn-large btn-block rounded-pill" id="box1"><strong>Display route</strong></button>
        </p></center>
		    
      </form>
    </div>

    <div class="col-sm-9" id="map">
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

        function onSuccess(result) {
            var route = result.response.route[0];
            addRouteShapeToMap(route);
            addManueversToMap(route);

            addWaypointsToPanel(route.waypoint);
            addManueversToPanel(route);
            addSummaryToPanel(route.summary);
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

        function addManueversToMap(route) {
            var svgMarkup = '',
                dotIcon = new H.map.Icon(svgMarkup, {
                    anchor: {
                        x: 8,
                        y: 8
                    }
                }),
                group = new H.map.Group(),
                i,
                j;

            for (i = 0; i < route.leg.length; i += 1) {
                for (j = 0; j < route.leg[i].maneuver.length; j += 1) {
                    maneuver = route.leg[i].maneuver[j];
                    var marker = new H.map.Marker({
                        lat: maneuver.position.latitude,
                        lng: maneuver.position.longitude
                    }, {
                        icon: dotIcon
                    });
                    marker.instruction = maneuver.instruction;
                    group.addObject(marker);
                }
            }

            group.addEventListener('tap', function(evt) {
                map.setCenter(evt.target.getGeometry());
                openBubble(
                    evt.target.getGeometry(), evt.target.instruction);
            }, false);

            map.addObject(group);
        }

        function addWaypointsToPanel(waypoints) {

            var nodeH3 = document.createElement('h3'),
                waypointLabels = [],
                i;

            for (i = 0; i < waypoints.length; i += 1) {
                waypointLabels.push(waypoints[i].label)
            }

            nodeH3.textContent = waypointLabels.join(' - ');
            routeInstructionsContainer.innerHTML = '';
            routeInstructionsContainer.appendChild(nodeH3);
        }

        function addSummaryToPanel(summary) {
            var summaryDiv = document.createElement('div'),
                content = '';
            content += 'Total distance: ' + summary.distance + 'm.';
            content += 'Travel Time: ' + summary.travelTime.toMMSS() + ' (in current traffic)';
            summaryDiv.style.fontSize = 'small';
            summaryDiv.style.marginLeft = '5%';
            summaryDiv.style.marginRight = '5%';
            summaryDiv.innerHTML = content;
            routeInstructionsContainer.appendChild(summaryDiv);
        }

        function addManueversToPanel(route) {
            var nodeOL = document.createElement('ol'),
                i,
                j;

            nodeOL.style.fontSize = 'small';
            nodeOL.style.marginLeft = '5%';
            nodeOL.style.marginRight = '5%';
            nodeOL.className = 'directions';

            // Add a marker for each maneuver
            for (i = 0; i < route.leg.length; i += 1) {
                for (j = 0; j < route.leg[i].maneuver.length; j += 1) {
                    // Get the next maneuver.
                    maneuver = route.leg[i].maneuver[j];

                    var li = document.createElement('li'),
                        spanArrow = document.createElement('span'),
                        spanInstruction = document.createElement('span');

                    spanArrow.className = 'arrow ' + maneuver.action;
                    spanInstruction.innerHTML = maneuver.instruction;
                    li.appendChild(spanArrow);
                    li.appendChild(spanInstruction);

                    nodeOL.appendChild(li);
                }
            }

            routeInstructionsContainer.appendChild(nodeOL);
        }

        Number.prototype.toMMSS = function() {
            return Math.floor(this / 60) + ' minutes ' + (this % 60) + ' seconds.';
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

</body>

</html>
