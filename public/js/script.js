var items = [];
var table = 
  '<table class="table table-bordered primary">' +
      '<thead>' +
        '<tr>' +
          '<th>Position</th>' +
          '<th>Name</th>' +
          '<th>Played</th>' +
          '<th>Won</th>' +
          '<th>Lost</th>' +
          '<th>Points</th>' +
        '</tr>' +
      '</thead>' +
      '<tbody>' 

$.getJSON( "ajax/data.json", function( data ) {

  data.employees.sort(function(a, b){

    var keyA = a.PTS,
        keyB = b.PTS;
    // Compare the 2 dates
    if(keyA > keyB) return -1;
    if(keyA < keyB) return 1;
    return 0;
  });

  $.each( data.employees, function( key, val ) {

    table +=  
    '<tr>' +
      '<td class="col-md-1">' + (key+1) + '</td>' +
      '<td class="col-md-4">' + val.Name + '</td>' +
      '<td class="col-md-2">' + val.PLD + '</td>' +
      '<td class="col-md-2">' + val.W + '</td>' +
      '<td class="col-md-2">' + val.L + '</td>' +
      '<td class="col-md-2">' + val.PTS + '</td>' +
    '</tr>' 
  })

  table +=  
    '</tbody>' +
  '</table>'

  $('#league-table').append(table)

})

