$(function(){
/**/
var COUNT_X = 3;
var path_log = new Array();
path_log.push(IMG_ARR.length);
$('.content img').bind('click',move);
$('#disturb').bind('click',disturb);

function move(event){
    var target = event.target;
    var neighbors = getNeighbors(target);
    for(var i=0; i<neighbors.length;i++){
        var neighbor = $('#img_'+neighbors[i]);
        if($(neighbor).attr('src') == 'xxx.gif'){
            $(neighbor).attr('src',$(target).attr('src')) 
            $(target).attr('src','xxx.gif');;
        }
    }
}
function getNeighbors(element){
    var index = getIndex($(element).attr('id'));
    var neighbors = new Array();
    if(index%COUNT_X != 1 ){
       neighbors.push(index-1);
    }
    if(index%COUNT_X != 0 ){
       neighbors.push(index+1);
    }
    if(index > COUNT_X ){
       neighbors.push(index-3);
    }
    if(index <= IMG_ARR.length-3  ){
       neighbors.push(index+3);
    }
    return neighbors;
}
function getIndex(str){
   var pattern = /img_(\d+)/;
   var id = pattern.exec(str)[1];
   return +id;
}
function verify(){

}
function disturb(){
    var space = $('img[src="xxx.gif"]');
    var neighbors = getNeighbors(space);
    var neighbors_new = new Array();
    //去除前一步人位置
    console.log('path-log==');
    console.log(path_log);
//    alert('111');
    for(var i=0;i<neighbors.length;i++){
        if(path_log[path_log.length-2] != neighbors[i]){
            neighbors_new.push(neighbors[i]);
        }
    }
    var next_position = array_random(neighbors_new);
    $(space).attr('src',$('#img_'+next_position).attr('src')) 
    $('#img_'+next_position).attr('src','xxx.gif');;
    path_log.push(next_position);
}
function array_random(arr){
    var random_index = Math.random();
    var percent = 1/arr.length;
    for(var i=0;i<arr.length; i++){
        if( random_index>=i*percent && random_index < (i+1)*percent){
            return arr[i];
        }
    }
}

/**/
});
