$(function( $ ){

    var selectedQuiz = 'General Theory Test';

    //Show the first question
    nextQuestion(selectedQuiz);
    // ajaxNext(selectedQuiz);


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
                    document.getElementById("quiz-content").innerHTML = 
                    document.getElementById("quiz-content").innerHTML + '<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>';
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

    //Prints a response using javascript
    // function ajaxNext(str) {
    //     $.ajax({
    //         type: "GET",
    //         url: "/ajax/quizajax.php",
    //         dataType: 'json',
    //         data: 'name=' + str,
    //         success: function(result) {
    //             $.each(result, function(rowIndex, row) { 
    //                 $(`
    //                     <div class="row no-gutters align-items-center justify-content-center">
    //                         <div class="col">RTA - QUIZ</div>
    //                         <div class="col"></div>
    //                         <div id="quiz-position" class="col text-right">Question: ` + (parseInt(row.answered)+1) + `/` + row.size + `</div>
    //                     </div>
    //                     <div class="row no-gutters align-items-center justify-content-center">
    //                         <div id="quiz-question" class="col">` + row.question + `</div> <!-- Question -->
    //                     </div>
    //                     <div class="row no-gutters align-items-center justify-content-center">
    //                         <div id="quiz-answer" class="col">
    //                 `).appendTo('#quiz-content');

    //                 //Loop through available choices for the question:
    //                 $.each(row.choices, function(index, value) {
    //                     $(`
    //                         <div class="form-check">
    //                         <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios` + row.id_choices[index] + `" value="` + row.id_choices[index] + `">
    //                         <label class="form-check-label" for="gridRadios` + row.id_choices[index] +  `">
    //                         ` + value + `
    //                         </label></div>
    //                     `).appendTo('#quiz-content');
    //                 });

    //                 //Insert next button
    //                 $(`</div></div><div class="row no-gutters align-items-center justify-content-center">
    //                         <button id="quiz-next" type="button" class="btn btn-primary">Next</button>
    //                     </div>`).appendTo('#quiz-nav');
    //             });
    //         },
    //         error: function(result) {
    //             alert('Invalid Response');
    //         }
    //     });
    // }
});

//Prints a response from PHP
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
        xmlhttp.open("GET","ajax/quiz.php?name="+str,true);
        xmlhttp.send();
    }
}