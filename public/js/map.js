/*map js*/

/*初始化*/
var map = new qq.maps.Map(document.getElementById("map"), {
    zoom : 12,
    center: new qq.maps.LatLng(39.916527,116.397128),
    disableDefaultUI: true
});

/* 自动设置地图城市 */
var citylocation = new qq.maps.CityService({
    complete : function(result){
        map.setCenter(result.detail.latLng);
    }
});
citylocation.searchLocalCity();

// 图上标记
var markersArray = [];
//删除标记
function addMarker(marker) {
    if (markersArray) {
        for (i in markersArray) {
            markersArray[i].setMap(null);
        }
        markersArray.length = 0;
    }
    markersArray.push(marker);
}

function showPositionFloat(latLng) {
    $('#longitude').val(latLng.lng);
    $('#latitude').val(latLng.lat);
}


/* 鼠标选点 */
qq.maps.event.addListener(map, 'click', function(event) {
    showPositionFloat(event.latLng);
    var marker=new qq.maps.Marker({
            position:event.latLng,
            map:map
        });
    addMarker(marker);
});


/*自动完成搜索*/
var autocompleteInput = new qq.maps.place.Autocomplete(document.getElementById('place'));
var searchService = new qq.maps.SearchService({
    complete : function(results){
       if(results.type === "CITY_LIST") {
          alert("当前检索结果分布较广，请定位到具体城市进行检索");
          return;
        }
        var pois = results.detail.pois;
        var latlngBounds = new qq.maps.LatLngBounds();
        for(var i = 0,l = pois.length;i < l; i++){
            var poi = pois[i];
            latlngBounds.extend(poi.latLng);
            var marker = new qq.maps.Marker({
                map:map,
                position: poi.latLng
            });
            showPositionFloat(poi.latLng);
            marker.setTitle(poi.name);
            addMarker(marker);
            break;
        }
        map.fitBounds(latlngBounds);
    }
});
qq.maps.event.addListener(autocompleteInput, "confirm", function(res){
    searchService.search(res.value);
});

/* init 地理位置，显示mark标记 */
function initMarkWithPosition(lng, lat)
{
    if (!lng || !lat) {
        return false;
    }
    //设置经纬度信息
    var latLng = new qq.maps.LatLng(lat, lng);
    //调用城市经纬度查询接口实现经纬查询
    citylocation.searchCityByLatLng(latLng);

    var marker=new qq.maps.Marker({
            position: latLng,
            map:map
        });
    addMarker(marker);
}
