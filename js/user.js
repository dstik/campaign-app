var User = function User() {
  var user = this;

  this.sendRequestViaMultiFriendSelector = function sendRequestViaMultiFriendSelector(inviteMessage) {
    FB.ui({method: 'apprequests',
      message: inviteMessage
    }, function(request_id, to_array){
      console.log("Handle this");
      console.log("Request Object ID: "+request_id);
      console.log("To (array):");
      console.log(to_array);
    });
  }

};

var user = new User();