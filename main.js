$(document).ready(function() {
  $('#submitWinLose').click(function() {
    var winner = $("#winner option[value='"+$("#winner").val()+"']").text();
    var loser = $("#loser option[value='"+$("#loser").val()+"']").text();
    var loser2 = $("#loser2 option[value='"+$("#loser2").val()+"']").text();
    if (!winner || !loser || !loser2 || winner == loser || winner == loser2 || loser == loser2) {
      alert('Invalid selection');
      return false;
    }
    var r = confirm("Are you sure?\nWinner: "+winner+"\nLoser: "+loser+"\nLoser 2: "+loser2);
    if (r == true) {
      return true;
    } else {
      return false;
    }
  });
  $('select').prop('selectedIndex', -1)
  $('#genMatches').click(function() {
    $.getJSON("getRandomGame.php", function(data){
      $('#aj p').text(data[0]);
      $('#alexis p').text(data[1]);
      $('#raizza p').text(data[2]);
    });
    return false;
  });
});
