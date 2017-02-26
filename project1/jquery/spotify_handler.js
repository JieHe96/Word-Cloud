function searchArtistName() {
	$("#testdiv").html("");	

	var inputname = $("#search_input").val();
	console.log(inputname);
	if(inputname.length > 0){
		$.ajax({
			url: 'php/communicator.php',
			type: 'POST',
			data: {inputname : inputname},
			success : function(data) {

				$("#testdiv").html(data);	

				//$('#search_input').hide();
			},

			error : function() {
				alert('Please type in valid artist name.');
			}
		});
	}

}

function searchSongs(text) {
	$("#testdiv").html("");	
	var songarray = [];
	console.log(text);
	if(text.length > 0){
		$.ajax({
			url: 'php/song_communicator.php',
			type: 'POST',
			data: {artistname : text},
			success : function(data) {
				console.log("return from song");
				songarray = eval(data);

				processSongLists(songarray);
			},

			error : function() {
				alert('Please type in valid artist name.');
			}
		});
	}


}

function processSongLists(songlists){
	var display = "";
	for(var i = 1; i < songlists.length; i++){
		display+=songlists[i];
		display+=' ';
		i++;
	}

	display = display.replace(/\n/g, '');
	display = display.replace(/(1409614312827)/g, '');
	// var arr = display.split(" ");
	var arr = ['a','a','a','b','b','c'];
	var freq_arr = {};
	freq_arr = countFreq(arr);
    var keys=[]; 
    var val=[]; 
    var p;
    for(p in freq_arr) {
    	if(Object.prototype.hasOwnProperty.call(freq_arr,p)) {
    		keys.push(p);
    	}
    }
    for(var key in freq_arr) {
    	val.push(freq_arr[key]);
	}
	var obj = {text : keys[0], size : val[0]};
	frequency_list.push(obj);
	console.log(frequency_list.length);	
}

function countFreq(arr) {
    var freq = {};

	for(var i = 0; i< arr.length; i++) {
    	var num = arr[i];
    	freq[num] = freq[num] ? freq[num]+1 : 1;
	}

	return freq;
}
