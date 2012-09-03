// Fonction d'affichage d'une carte avec Openlayers
/**
 * @author Patindsaongo SAM
 */
/**
 * @todo Probleme le scale
 * @todo  Prend en compte le style d'affichage des covers lors la présentation statistique
 */


function statmap(covers, blocId, mapCenter, scale){

	var srcproj = new OpenLayers.Projection("EPSG:4326");
	var destproj = new OpenLayers.Projection("EPSG:900913");
	var osm = new OpenLayers.Layer.OSM();
	var crs = new OpenLayers.Layer.Vector('Covers');
	
	if(covers!=''){	
		var features = new Array();	
		var l = covers.length;
		
		for (var i = 0; i < l; i++) {
			var geometry = new OpenLayers.Geometry.fromWKT(covers[i][0]) ;	
			geometry.transform(srcproj, destproj);			
			var style = {fill:'true',
						 fillOpacity:'0.5',
						 fillColor:covers[i][1],
						 stroke:'true',
						 strokeOpacity:'1',
						 strokeColor:'#222222',
						 strokeWidth:'0.5',
						 label:covers[i][2],
						 labelAlign:'m',
						 fontSize:'12'};
			var feature = new OpenLayers.Feature.Vector(geometry,{},style);		    
		    features.push(feature);            
		}			
		crs.addFeatures(features); 	
	}

	
	var map = new OpenLayers.Map(								 
								{	
									div: blocId,
									controls: [
									new OpenLayers.Control.Navigation(),
									new OpenLayers.Control.PanZoomBar(),
									new OpenLayers.Control.LayerSwitcher({'ascending':false,}),
									new OpenLayers.Control.Permalink(),
									new OpenLayers.Control.ScaleLine(),
									new OpenLayers.Control.Permalink('permalink'),
									new OpenLayers.Control.MousePosition(),
									new OpenLayers.Control.OverviewMap(),
									],										 
								units: 'm',
								layers: [osm,crs],
								maxExtent: new OpenLayers.Bounds(-6.036, 2.6 , 6.036, 14.6),

								} );
	
	var point = new OpenLayers.LonLat(-1.036,12.6).transform(srcproj,  map.getProjectionObject());

	map.setCenter(point, 7 );
    

}


/**
 * @param layers
 * @param mapfile
 * @param lonlat
 * @param mapCenter
 * @param scale
 * @version 0.1
 */
function map(covers, lonlat, mapCenter, scale) {
	
    /*var result_style = OpenLayers.Util.applyDefaults({
        strokeWidth: 3,
        strokeColor: "#ff0000",
        fillOpacity: 50
    }, OpenLayers.Feature.Vector.style['default']);*/

	var srcproj = new OpenLayers.Projection("EPSG:4326");

	// Map initialisation	
	var map = new OpenLayers.Map('map',
								{maxResolution: 15000,
								projection: new OpenLayers.Projection("EPSG:900913"),
								controls: [
									new OpenLayers.Control.Navigation(),
									new OpenLayers.Control.PanZoomBar(),
									new OpenLayers.Control.LayerSwitcher({'ascending':false,}),
									new OpenLayers.Control.Permalink(),
									new OpenLayers.Control.ScaleLine(),
									new OpenLayers.Control.Permalink('permalink'),
									new OpenLayers.Control.MousePosition(),
									new OpenLayers.Control.OverviewMap(),
									],										 
								maxExtent: new OpenLayers.Bounds(-20037508.34, -20037508.34, 20037508.34, 20037508.34), units: 'm',
								} );
								
	// End of Map initialisation
	
	// Map layers 
	// BaseLayer	
	
	var baselayer = new OpenLayers.Layer.WMS( 
			'Burkina-Faso',			
			"http://localhost/cgi-bin/mapserv?map=/var/www/geos/src/Geos/GeoEntityBundle/Map/mapfile.map&", 
			{
				//transparent : 'true',
				layers: 'region,province,commune,pointeau', 
				format: 'image/png',

			}
		);

	var osm = new OpenLayers.Layer.OSM();	
	
	//map.addLayer(baselayer);
	map.addLayer(osm);
	
	//End of BaseLayer	
	
	// Covers
	
	if(covers!=''){
		var crs = new OpenLayers.Layer.Vector('Covers');
		var features = new Array();		
		l = covers.length;
		
		for (var i = 0; i < l; i++) {

			var geometry = new OpenLayers.Geometry.fromWKT(covers[i]) ;			
			geometry.transform(srcproj, map.getProjectionObject());
		    var feature = new OpenLayers.Feature.Vector(geometry);
		    features.push(feature);            
		}		
		crs.addFeatures(features); 
		
		map.addLayer(crs);
	}

	// End of covers
	
	// Markers
	
	if (lonlat != '')
	{
		var markers = new OpenLayers.Layer.Markers("Marqueurs");		
		addMarkers(map,lonlat,markers);	
	    map.addLayer(markers);    	    
	}
	
	//End of Makers
    
	//MapCenter
	
	var point, scl; 
	

    if (mapCenter!='') {
		point = new OpenLayers.LonLat(mapCenter[0],mapCenter[1]);
		scl = scale;
    }   
    else {
		point = new OpenLayers.LonLat(-1, 12);
		point.transform(srcproj,map.getProjectionObject() );
    }
    
	if (!map.getCenter()) {
		map.setCenter(point, -1 );
	}	    
   //End of MapCenter
}

// Fonction de de création des marqueurs à afficher
/**
 * @param mNb : nombre de marqueurs à afficher
 * @param mkr:  
 */
function addMarkers(map,mNb, mkr) {
	var markers = mkr;
    var ll, popupClass, popupContentHTML;
    
    var proj = new OpenLayers.Projection("EPSG:4326");
    //var point = new OpenLayers.LonLat(-71, 42);
   // point.transform(proj, map.getProjectionObject());

	if(mNb!=''){
		l = mNb.length;
		for (var i = 0; i < l; i++) {			
            ll = new OpenLayers.LonLat(mNb[i][0],mNb[i][1]);
            ll.transform(proj, map.getProjectionObject());
            popupClass = OpenLayers.Popup.Anchored;
            popupContentHTML = mNb[i][2];
            addMarker(markers,ll, popupClass, popupContentHTML);
		}
	}
}

/**
 * @param mkr
 * @param ll
 * @param popupClass
 * @param popupContentHTML
 * @param closeBox
 * @param overflow
 */
function addMarker(mkr,ll, popupClass, popupContentHTML, closeBox, overflow) {

    var feature = new OpenLayers.Feature(mkr, ll); 
    feature.closeBox = closeBox;
    feature.popupClass = popupClass;
    feature.data.popupContentHTML = popupContentHTML;
    feature.data.overflow = (overflow) ? "auto" : "hidden";
            
    var marker = feature.createMarker();

    var markerClick = function (evt) {
        if (this.popup == null) {
            this.popup = this.createPopup(this.closeBox);
            mkr.map.addPopup(this.popup);
            this.popup.show();
        } else {
            this.popup.toggle();
        }
        currentPopup = this.popup;
        OpenLayers.Event.stop(evt);
    };
    marker.events.register("mousedown", feature, markerClick);

    mkr.addMarker(marker);
}

// Jquery

/**
 * Fonctions de chargement de la liste des zones
 */
function getChildLocation0(){
	//alert($("#location0").children('select').val());
    $.ajax({
        type: "GET",
        data: "data=" + $("#location0").children('select').val(),
        url:"http://localhost/geos/web/app_dev.php/getProvincesByRegion",
        success: function(msg){
            if (msg != ''){
                $("#location1").children('select').html(msg).show();
            }
        }
    });
    $("#location2").children('select').html("<option value = ''> choisir une commune</option>").show();
    $("#location3").children('select').html("<option value = ''> choisir une section</option>").show();
    $("#location4").children('select').html("<option value = ''> choisir un lot</option>").show();
    $("#location5").children('select').html("<option value = ''> choisir une parcelle</option>").show();
}

function getChildLocation1(){
    $.ajax({
        type: "GET",
        data: "data=" + $("#location1").children('select').val(),
        url:"http://localhost/geos/web/app_dev.php/getCommunesByProvince",
        success: function(msg){
            if (msg != ''){
                $("#location2").children('select').html(msg).show();
            }
        }
    });
    $("#location3").children('select').html("<option value = ''> choisir une section</option>").show();
    $("#location4").children('select').html("<option value = ''> choisir un lot</option>").show();
    $("#location5").children('select').html("<option value = ''> choisir une parcelle</option>").show();
 }

function getChildLocation2(){
    $.ajax({
        type: "GET",
        data: "data=" + $("#location2").children('select').val(),
        url:"http://localhost/geos/web/app_dev.php/getSectionsByCommune",
        success: function(msg){
            if (msg != ''){
                $("#location3").children('select').html(msg).show();
            }
        }
    });
    $("#location4").children('select').html("<option value = ''> choisir un lot</option>").show();
    $("#location5").children('select').html("<option value = ''> choisir une parcelle</option>").show();
}
function getChildLocation3(){
    $.ajax({
        type: "GET",
        data: "data=" + $("#location3").children('select').val(),
        url:"http://localhost/geos/web/app_dev.php/getLotsBySection",
        success: function(msg){
            if (msg != ''){
                $("#location4").children('select').html(msg).show();
            }
        }
    });
    $("#location5").children('select').html("<option value = ''> choisir une parcelle</option>").show();
}

function getChildLocation4(){
    $.ajax({
        type: "GET",
        data: "data=" + $("#location4").children('select').val(),
        url:"http://localhost/geos/web/app_dev.php/getParcellesByLot",
        success: function(msg){
            if (msg != ''){
                $("#location5").children('select').html(msg).show();
            }
        }
    });
}

/**
 * Obtenir de la liste des entités d'un type de zone 
 */

function getZone(){	
	$.ajax({
		type: "GET",
		data: "data="+$('#indicateur_parameter_hierarchie').val(),
		url:"http://localhost/geos/web/app_dev.php/getZoneTypeEntities",
		success: function(msg){
            if (msg != ''){
                $("#indicateur_parameter_zone").html(msg).show();
            }
		}
	});	
}