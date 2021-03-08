$(function( $ ){

    var selectedQuiz = 'motorbike';

    //Show the first question
    nextQuestion(selectedQuiz);

    $("button").click(function(e) {
        e.preventDefault();

        //Gets the selected answer
        var checkedRadio = $('input[type=radio][name=gridRadios]:checked').attr('id');
        if(checkedRadio != null) {
            var answerID = checkedRadio.split('gridRadios')[1];
            //Submit the answer
            $.ajax({
                type: "POST",
                url: "/ajax/answer.php",
                dataType: 'text',
                data: 'answer=' + answerID,
                beforeSend: function(){
                    $('#ajaxLoading').show();
                },
                success: function(result) {
                    nextQuestion(selectedQuiz);
                },
                error: function(result) {
                    alert('Invalid Response');
                }
            });
        } else {
            alert('Please select an answer before continuing');
        }
    });
});

function nextQuestion(str) {
    if (str == "") {
        document.getElementById("quiz-content").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                $('#ajaxLoading').hide();
                document.getElementById("quiz-content").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","ajax/quiz.php?name="+str,true);
        xmlhttp.send();
    }
}

// function ajaxNext(str) {
//     $.ajax({
//         type: "GET",
//         url: "/ajax/quizajax.php",
//         dataType: 'text',
//         data: 'name=' + str,
//         beforeSend: function(){
//             $('#ajaxLoading').show();
//         },
//         success: function(result) {
//             nextQuestion(selectedQuiz);
//         },
//         error: function(result) {
//             alert('Invalid Response');
//         }
//     });
// }