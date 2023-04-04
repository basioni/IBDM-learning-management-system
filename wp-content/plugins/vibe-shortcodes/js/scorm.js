var LMS_Object;
var LMS_API = {
  Initialize: function(){
  	console.log('Initialize');
  	//Read manifest adn get the package name
  },
  GetLastError:function(){
    return 'error';
  },
  SetValue(type,value){
  	console.log('Set Value');
    console.log(type);
    console.log(value);
    console.log('----');
  },
  GetValue(type){
  	console.log('Get Value');
    console.log(type);
    console.log('----');
  },
  Commit(args){
  	console.log('Commit');
    console.log(args);
    console.log('----');
    return true;
  },
  Terminate(args){
  	console.log('terminate');
    console.log(args);
    console.log('----');
    return true;
  },
  Finish(args){
  	console.log('Finish');
    console.log(args);
    console.log('----');
    return true;
  },
};
