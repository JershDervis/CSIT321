$('document').ready(function(){
    

    nextQuestion('motorbike');
});
//#quiz-content = ajax request of quiz.php

function nextQuestion(str) {
    if (str == "") {
        document.getElementById("quiz-content").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("quiz-content").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","quiz.php?name="+str,true);
        xmlhttp.send();
    }
}