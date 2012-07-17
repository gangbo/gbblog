$(function(){
/**/
var COUNT_X = 3;
var path_log = new Array();
var user_step_log = new Array();
var is_start = false;
path_log.push(IMG_ARR.length);
$('.content img').bind('click',move);
$('.disturb').bind('click',disturb);

function move(event){
    if(!is_start){
        return;
    }
    var target = event.target;
    var neighbors = getNeighbors(target);
    for(var i=0; i<neighbors.length;i++){
        var neighbor = $('#img_'+neighbors[i]);
        if($(neighbor).attr('src') == 'xxx.gif'){
            $(neighbor).attr('src',$(target).attr('src')) 
            $(target).attr('src','xxx.gif');;
            user_step_log.push(neighbors[i]);
        }
    }
    if(verify()){
        var step_num = path_log.length - 1;
        is_start = false;
        alert('你真是太厉害了,总共用了'+user_step_log.length+'步');
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
    for( var i=1; i<IMG_ARR.length; i++){
        if($('#img_'+i).attr('src') != IMG_ARR[i-1]){
           return false;
        }
    }
    return true;
}
function disturb(e){
    var level = $(e.target).attr('data-value');
    for(var i=0;i<level;i++){
        disturb_one();
    }
    user_step_log = new Array();
    is_start = true;
}
function disturb_one(e){
    var space = $('img[src="xxx.gif"]');
    var neighbors = getNeighbors(space);
    var neighbors_new = new Array();
    //去除前一步人位置
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
