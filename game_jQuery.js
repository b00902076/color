var lv = $(".lv");
var container = $(".mycontainer");
var grid = $(".grid");
var help_btn = $(".help_btn");
var kichiku_btn = $(".kichiku_btn");
var reset = $(".reset");
var tmp = lv[0].textContent;
var color = [], print = [], Sort = [];
var colorStr ="", mode="normal", pre_mode="normal";
var level=0, ans, dificulty_rate = 0.95, dist = 50, opac=0.5, gameOver = false, highScore=0;
var n;

function randColor(dist){
    return Math.floor(Math.random()*(256-1*dist));
}

function difficulty(level){
	return 0.4*Math.pow(dificulty_rate, level);
}

function transform(){
	//console.log("Sort[0]= "+Sort[0]+" level= "+level+"\n"+"diff= "+difficulty(level));
    if(Sort[0] < 1.5*dist)  return opac+0.1+difficulty(level);
    if(Sort[0] < 1.8*dist)  return opac+0.05+difficulty(level);
    return opac+difficulty(level);
}

function initial(){
    lv.text( tmp+level );
    //while(1){
        color = [randColor(dist), randColor(dist), randColor(dist)];
        
    //}
    var avg = (color[0]+color[1]+color[2])/3;
    var v = ((color[0]-avg)*(color[0]-avg)+(color[1]-avg)*(color[1]-avg)+(color[2]-avg)*(color[2]-avg))/3;
    Sort = color.sort(function (a,b){return (a>b)? -1:1;});
    ans = Math.floor(Math.random()*16);
    for(var i=0; i<16; i++){
        print = color.slice();
        print.push(opac);
        if(i === ans){
            print[3]=transform();
            $(grid[i]).addClass("ans");
        }
        colorStr = "rgba("+print[0]+", "+print[1]+", "+print[2]+", "+print[3]+")";
        if(i === (ans+1)%16)	{console.log(colorStr);console.log("v= "+v);}
        $(grid[i]).css("background", colorStr);
    }
}

function change_mode(cmd){
    if(cmd === "help")      container.toggleClass(cmd);
    if(cmd === "kichiku"){
        for(var i=0; i<16; i++) $(grid[i]).toggleClass(cmd);
    }
    
}

function click_grid(num){
    function callback(){
        if(gameOver === false && $(this).hasClass("ans")){
            $(this).removeClass("ans");
            level++;
            initial();
        }
        else{
            gameOver = true;
            highScore = (level > highScore)? level:highScore;
            lv.html( "Game Over. Press RESET button to restart." );
            $(grid[ans]).addClass("border");
        }
    }
    return callback;
}

function my_prompt(){
    $.confirm({
        title: 'Prompt!',
        content: '' +
        '<form action="" class="formName">' +
        '<div class="form-group">' +
        '<label>Enter something here</label>' +
        '<input type="text" placeholder="Your name" class="name form-control" required />' +
        '</div>' +
        '</form>',
        buttons: {
            formSubmit: {
                text: 'Submit',
                btnClass: 'btn-blue',
                action: function () {
                    var name = this.$content.find('.name').val();
                    if(!name){
                        $.alert('provide a valid name');
                        return false;
                    }
                    $.alert('Your name is ' + name);
                }
            },
            cancel: function () {
                //close
            },
        },
        onContentReady: function () {
            // bind to events
            var jc = this;
            this.$content.find('form').on('submit', function (e) {
                // if the user submits the form by pressing enter in the field.
                e.preventDefault();
                jc.$$formSubmit.trigger('click'); // reference the button and click it
            });
        }
    });
    
}

function click_reset(){
    function callback(){
        gameOver = false;
        //$.alert("YOOOOOO");
        
        //level = 0;
        container.removeClass("help");
        
        for(var i=0; i<16; i++) $(grid[i]).removeClass("kichiku");
        $(grid[ans]).removeClass("ans");
        $(grid[ans]).removeClass("border");
        if(level !== 0){
            
            n = "";
            while(n === "" || n === null){
                n = prompt("名前を入力してください", "NoName");
                //my_prompt();
                
                if(n === null){
                    var confirm_state;
                    //console.log("YOOOOOOOOOOOOO");
                    
                    /*
                    $.confirm({
                                title: '警告',
                                content: 'このウインドウを消しますと、スコア記録が破棄されます。\n本当に破棄しますか。',
                                buttons: {
                                    button1: {
                                        text: 'はい',
                                        //btnClass: 'btn-blue',
                                        //keys: ['enter', 'shift'],
                                        action: function(){
                                            confirm_state = 'Yes';
                                            $.alert('め！');
                                        }
                                    },
                                    button2: {
                                        text: 'いいえ',
                                        //btnClass: 'btn-blue',
                                        //keys: ['enter', 'shift'],
                                        action: function(){
                                            confirm_state = 'No';
                                        }
                                    }
                                }
                            });
                            */
                    /*
                    $.confirm({
                                title: 'Confirm!',
                                content: 'Simple confirm!',
                                buttons: {
                                    confirm: function () {
                                        $.alert('Confirmed!');
                                    },
                                    cancel: function () {
                                        $.alert('Canceled!');
                                    },
                                    somethingElse: {
                                        text: 'Something else',
                                        btnClass: 'btn-blue',
                                        keys: ['enter', 'shift'],
                                        action: function(){
                                            $.alert('Something else?');
                                        }
                                    }
                                }
                            });
                     */
                    if(confirm("このウインドウを消しますと、スコア記録が破棄されます。\n本当に破棄しますか。")) break;
                    //console.log("?????????????????????");
                    
                }
            }
            if(n !== "" && n!==null){
                document.myform.name.value = n;
                document.myform.score.value = level;
                //document.myform.submit();
            }
        }
        level = 0;
        initial();
    }
    return callback;
}

function click_change(cmd){
    function callback(){
        change_mode(cmd);
    }
    return callback;
}

/*
***************************************
            main code
***************************************
*/

grid.click( click_grid( grid.index(this) ) );
help_btn.click( click_change("help") );
kichiku_btn.click( click_change("kichiku") );
reset.click( click_reset() );

initial();