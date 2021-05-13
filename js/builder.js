$j(function(){
    //Enable tooltips:
    $j('[data-toggle="tooltip"]').tooltip()

    //On show remove unit dialog:
    $j('#removeUnitDialog').on('show.bs.modal', function (event) {
        var button = $j(event.relatedTarget);
        var unitName = button.data('whatever');
        var modal = $j(this);
        modal.find('.modal-title').text('Remove unit "' + unitName + '"');
        modal.find('.modal-body input').val(unitName);
    });
    //Remove Unit:
    $j('#btn-remove-unit').on('click', function (event) {
        var unitToRemove = $j('#remove-unit-name').val();
        $j.ajax({
            type: "POST",
            url: "/ajax/builder/remove-unit.php",
            dataType: 'text',
            data: 'name=' + unitToRemove,
            beforeSend: function(){
                $j("#btn-remove-unit-outer").html(`<button id="btn-remove-unit" type="button" class="btn btn-danger" disabled>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                </button>`);
            },
            success: function(result) {
                console.log(result);
                $j("#btn-remove-unit-outer").html('<button id="btn-remove-unit" type="button" class="btn btn-danger">Remove</button>');
                var data = JSON.parse(result);
                $j('#card-' + data.unitID).remove();
                $j("#removeUnitDialog").modal("hide");
            },
            error: function(result) {
                alert('Invalid Response');
                $j("#btn-remove-unit-outer").html('<button id="btn-remove-unit" type="button" class="btn btn-danger">Remove</button>');
            }
        });
    });

    //Add Unit:
    $j('#addUnitDialog').on('hidden.bs.modal', function () {
        $j("#add-unit-warning").remove(); //If a warning was left it will be removed.
    });
    $j('#btn-add-unit').on('click', function (event) {
        $j("#add-unit-warning").remove();
        var unitName = $j("#add-unit-name").val();
        if(unitName === "") {
            $j("#add-modal-body").append('<div class="alert alert-warning" role="alert" id="add-unit-warning">Please enter a valid unit name</div>');
        } else {
            $j.ajax({
                type: "POST",
                url: "/ajax/builder/add-unit.php",
                dataType: 'text',
                data: 'name=' + unitName,
                beforeSend: function(){
                    $j("#btn-add-unit-outer").html(`<button id="btn-add-unit" type="button" class="btn btn-primary" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                    </button>`);
                },
                success: function(result) {
                    $j("#btn-add-unit-outer").html('<button id="btn-add-unit" type="button" class="btn btn-primary">Add</button>');
                    //Add new unit to the accordion (get result response):
                    var data = JSON.parse(result);
                    $j("#accordion").append(
                        `<div id="card-${data.unitID}" class="card">
                            <div class="card-header" id="heading-${data.unitName}">
                                <div class="row">
                                    <div class="col">
                                        <h5>
                                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse-${data.unitID}" aria-expanded="true" aria-controls="collapse-${data.unitID}" data-whatever="${data.unitID}">
                                                ${data.unitName} <!-- Capitlise -->
                                            </button>
                                        </h5>
                                    </div>

                                    <!-- Toggle unit available to public TODO: check if unit is public and mark as checked -->
                                    <div class="col-md-auto align-self-center">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="switch-public-${data.unitID}" data-whatever="${data.unitID}">
                                            <label class="custom-control-label" for="switch-public-${data.unitID}" data-toggle="tooltip" title="Toggle content visibility for all users">Public</label>
                                        </div>
                                    </div>

                                    <!-- Remove Unit -->
                                    <div class="col col-lg-2 align-self-center">
                                        <button type="button" id="removeModal" class="btn btn-outline-danger float-right" data-toggle="modal" data-target="#removeUnitDialog" data-whatever="${data.unitName}">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Unit Content: -->
                            <div id="collapse-${data.unitID}" class="collapse" aria-labelledby="heading-${data.unitID}" data-parent="#accordion">
                                <div class="card-body">
                                    <div id="unit-content-${data.unitID}">
                                        <div class="d-flex justify-content-center">
                                            <div class="spinner-border" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `
                    );
                    $j("#addUnitDialog").modal("hide");
                    $j("#add-unit-name").val('');
                },
                error: function(result) {
                    alert('Invalid Response');
                    $j("#btn-add-unit-outer").html('<button id="btn-add-unit" type="button" class="btn btn-primary">Add</button>');
                }
            });
        }
    });
    //Add Unit enter key press
    $j('#addUnitDialog').on('keypress', function (event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            $j('#btn-add-unit').click();   
        }
    });

    //Toggle published checkbox
    $j('#accordion').on('change', 'input:checkbox', function(event) {
        var toggle = $j(event.target);
        var unitID = toggle.data('whatever');   //UnitID
        var checked = toggle.prop('checked') ? 1 : 0; //True/false
        //Change visibility state
        $j.ajax({
            type: "POST",
            url: "/ajax/builder/published-unit.php",
            dataType: 'text',
            data: { unit: unitID, newState: checked.toString()},
            success: function(result) {
            },
            error: function(result) {
                console.log("ERROR:");
                console.log(result);
            }
        });
    });

    //Get and display unit content:
    $j('#accordion').on('show.bs.collapse', function (e) {
        var button = $j(e.target).parent().find('button');
        var unitID = button.data('whatever');
        if(unitID == null) { //Check if this is the correct accordion
            return;
        } else {
            //Show loading..
            document.getElementById("unit-content-"+unitID).innerHTML = `
            <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>`;

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("unit-content-"+unitID).innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET","ajax/builder/unit-content.php?id="+unitID,true);
            xmlhttp.send();
        }
    });

    //Get and display quiz content:
    $j(document).on("show.bs.collapse", '.accordion-inner', function(event) { //TODO: Fix unitID
        var button = $j(event.target).parent().find('button');
        var quizID = button.data('qid');
        if(quizID == null) { //Check if this is the correct accordion
            return;
        } else {
            //Show loading..
            document.getElementById("quiz-content-"+quizID).innerHTML = `
            <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>`;

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("quiz-content-"+quizID).innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET","ajax/builder/quiz-content.php?id="+quizID,true);
            xmlhttp.send();
        }
    });

    $j(document).on("change", '.unit-file-update', function(event) { //TODO: Fix unitID
        var upl = $j(event.target);
        var unitID = upl.data('img-unit');  

        var file = $j(this)[0].files[0];
        var form_data = new FormData();  // Create a FormData object
        form_data.append('image', file);
        form_data.append('unitID', unitID);

        $j.ajax({
            url         : 'ajax/builder/upload-unit.php',     // point to server-side PHP script 
            dataType    : 'text',           // what to expect back from the PHP script, if anything
            cache       : false,
            contentType : false,
            processData : false,
            data        : form_data,                         
            type        : 'post',
            beforeSend  : function() {
                //Show loading icon..
            },
            success     : function(output){
                var res = JSON.parse(output);
                document.getElementById("unit-card-" + unitID).src= "/uploads/" + res.loc_name;
            }
        });
    });
    
    //Add quiz
    $j(document).on('click', '#btn-add-quiz', function (event) {
        var btn = $j(event.target);
        var unitID = btn.data('uid');  
        var quizName = $j("#add-quiz-name").val();

        $j("#add-quiz-warning").remove();
        if(quizName === "") {
            $j("#add-quiz-modal-body").append('<div class="alert alert-warning" role="alert" id="add-unit-warning">Please enter a valid quiz name</div>');
        } else {
            $j.ajax({
                type: "POST",
                url: "/ajax/builder/add-quiz.php",
                dataType: 'text',
                data: { name: quizName, uid: unitID},
                beforeSend: function(){
                },
                success: function(result) {
                    var data = JSON.parse(result);
                    $j("#quiz-list-" + data.unitID).append(
                        `<div id="card-quiz-${data.quizID}" class="card">
                        <div class="card-header" id="heading-quiz-${data.quizID}">
                            <div class="row">
                                <div class="col">
                                    <h5 class="mb-0">
                                        <button class="btn-inner-accordion btn btn-link" data-toggle="collapse" data-target="#collapse-quiz-${data.quizID}" aria-expanded="true" aria-controls="collapse-quiz-${data.quizID}" data-qid="${data.quizID}">
                                            ${data.quizName}
                                        </button>
                                    </h5>
                                </div>
                                <div class="col-md-auto align-self-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="quiz-published-check custom-control-input" id="switch-public-quiz-${data.quizID}" data-qid="${data.quizID}">
                                        <label class="custom-control-label" for="switch-public-quiz-${data.quizID}" data-toggle="tooltip" title="Toggle content visibility for all users">Public</label>
                                    </div>
                                </div>
                                <div class="col col-lg-2 align-self-center">
                                    <button type="button" class="btn-remove-quiz btn btn-outline-danger float-right" data-qid="${data.quizID}">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="collapse-quiz-${data.quizID}" class="collapse" aria-labelledby="heading-quiz-${data.quizID}" data-parent="#quiz-list-${data.unitID}">
                            <div class="card-body">
                                <div id="quiz-content-${data.quizID}">
                                    <div class="d-flex justify-content-center">
                                        <div class="spinner-border" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        `
                    );
                    //
                    $j("#addQuizDialog").modal("hide");
                    $j("#add-quiz-name").val('');
                },
                error: function(result) {
                    console.log(result);
                }
            });
        }
    });
    //Add quiz enter key press
    $j('#addQuizDialog').on('keypress', function (event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            $j('#btn-add-quiz').click();   
        }
    });
    $j('#addQuizDialog').on('show.bs.modal', function (event) {
        var button = $j(event.relatedTarget);
        var unitID = button.data('uid');
        $j('.btn-add-quiz-outer').html(`<button id="btn-add-quiz" type="submit" class="btn btn-primary" data-uid="${unitID}">Add</button>`);
    });

    //Remove quiz
    $j(document).on('click', '.btn-remove-quiz', function (event) {
        var btn = $j(event.target);
        var quizID = btn.data('qid');  
        $j.ajax({
            type: "POST",
            url: "/ajax/builder/remove-quiz.php",
            dataType: 'text',
            data: 'qid=' + quizID,
            beforeSend: function(){
                btn.prop('disabled', true);
                btn.html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`);
            },
            success: function(result) {
                var data = JSON.parse(result);
                $j('#card-quiz-' + data.qid).remove();
            },
            error: function(result) {
                alert('Invalid Response');
                btn.text('Remove');
                btn.removeAttr('disabled');
            }
        });
    });

    //Toggle published checkbox
    $j(document).on('change', '.quiz-published-check', function (event) {
        var toggle = $j(event.target);
        var quizID = toggle.data('qid');   //UnitID
        var checked = toggle.prop('checked') ? 1 : 0; //True/false
        // Change visibility state
        $j.ajax({
            type: "POST",
            url: "/ajax/builder/published-quiz.php",
            dataType: 'text',
            data: { qid: quizID, newState: checked.toString()},
            success: function(result) {
            },
            error: function(result) {
                console.log("ERROR:");
                console.log(result);
            }
        });
    });

    //Click add question
    $j(document).on('click', '#addQuestionModal', function (event) {
        var btn = $j(event.target);
        var quizID = btn.data('qid');
        $j("#btn-add-question").data('qid', quizID);
        $j(".custom-file-label").html("Choose file");
    });

    //Close add question
    $j('#addQuestionDialog').on('hidden.bs.modal', function (event) {
        $j("#btn-add-question").data("qfid", ""); //Reset
        $j("#add-response").data("count", "0"); //Reset
        $j("#add-question-name").val("");
        $j(".custom-file-label").empty();
        $j("#temp-img-disp").remove();
        $j("#add-question-response").empty();
    });

    //Add question file upload
    $j(document).on("change", '.custom-file-input', function(event) { 
        $j("#temp-img-disp").remove();

        var fileName = $j(this).val().split("\\").pop();
        $j(this).siblings(".custom-file-label").addClass("selected").html(fileName);

        var upl = $j(event.target);

        var file = $j(this)[0].files[0];
        var form_data = new FormData();  // Create a FormData object
        form_data.append('image', file);

        $j.ajax({
            url         : 'ajax/builder/upload-question.php',     // point to server-side PHP script 
            dataType    : 'text',           // what to expect back from the PHP script, if anything
            cache       : false,
            contentType : false,
            processData : false,
            data        : form_data,                         
            type        : 'post',
            beforeSend  : function() {
                //Show loading icon..
                $j("#btn-add-question").prop('disabled', true);
            },
            success     : function(output){
                var res = JSON.parse(output);
                var nextQuestionFileID = res.id;
                $j("#btn-add-question").data("qfid", nextQuestionFileID);
                $j("#btn-add-question").prop('disabled', false);
                $j("#add-question-modal-body").append(`<img width="64px" height="64px" id="temp-img-disp" src="/uploads/${res.loc_name}"></img>`);
            }
        });
    });

    //Final Add Question
    $j(document).on('click', '#btn-add-question', function (event) {
        event.preventDefault();
        var btn = $j(event.target);
        var quizID = btn.data('qid');  
        var fileID = btn.data('qfid');
        var question = $j("#add-question-name").val();

        var answers = new Array();
        var correctness = new Array();
        $j('.response-input').each(function(){
            answers.push($j(this).val());
        });
        $j('.response-checkbox').each(function(){
            correctness.push(this.checked ? 1 : 0);
        });

        $j.ajax({
            type: "POST",
            url: "/ajax/builder/add-question.php",
            dataType: 'text',
            data: { 
                quizID:     quizID, 
                question:   question,
                fileID:     fileID,
                answers:    answers,
                correct:    correctness
            },
            beforeSend  : function() {
                //Show loading icon..
                $j("#btn-add-question").prop('disabled', true);
                $j("#btn-add-question").text('Loading...');
            },
            success: function(result) {
                var data = JSON.parse(result);
                $j('#quiz-question-list-' + data.quizID).append(
                    `<div id="qq-question-${data.id}">
                        <div class="row">
                            <div class="col-lg">
                                <button disabled type="button" class="quiz-question list-group-item list-group-item-action" data-toggle="modal" data-target="#editQuizDialog" data-qid="${data.id}">
                                ${data.question}
                                </button>
                            </div>
                            <div class="col-md-auto align-self-center">
                                <button type="button" class="btn-remove-question btn btn-outline-danger float-right" data-qid="${data.id}">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>`
                );
                $j("#addQuestionDialog").modal("hide");
                $j("#btn-add-question").prop('disabled', false);
                $j("#btn-add-question").text('Add');
            },
            error: function(result) {
                console.log("ERROR:");
                console.log(result);
                $j("#btn-add-question").prop('disabled', false);
                $j("#btn-add-question").text('Add');
            }
        });
    });

    //Remove quiz question
    $j(document).on('click', '.btn-remove-question', function(event) {
        var btn = $j(event.target);
        var questionID = btn.data('qid');
        $j.ajax({
            type: "POST",
            url: "/ajax/builder/remove-question.php",
            dataType: 'text',
            data: 'qid=' + questionID,
            beforeSend: function(){
                btn.prop('disabled', true);
                btn.html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`);
            },
            success: function(result) {
                var data = JSON.parse(result);
                $j('#qq-question-' + data.qid).remove();
            },
            error: function(result) {
                alert('Invalid Response');
                btn.text('Remove');
                btn.removeAttr('disabled');
            }
        });    
    });

    //Click edit question
    $j(document).on('click', '.quiz-question', function (event) {
        var btn = $j(event.target);
        var quizID = btn.data('qid');
        $j("#btn-add-question").data('qid', quizID);
        console.log(quizID);
    });

    $j(document).on('click', '#add-response', function(event) {
        event.preventDefault();
        var aref = $j(event.target);
        aref.data('count', aref.data('count')+1);
        $j('#add-question-response').append(
            `
            <div class="row">
                <div class="col">
                    <label for="add-response-name-${aref.data('count')}" class="response-lbl col-form-label">Answer:</label>
                </div>
            </div>
            <div class="row">
                <div class="col-lg">
                    <input type="text" class="response-input form-control" id="add-response-name-${aref.data('count')}" required>
                </div>
                <div class="col-md-auto align-self-center">
                    <div class="form-check form-switch">
                        <input class="response-checkbox form-check-input" type="checkbox" id="response-check-${aref.data('count')}">
                        <label class="form-check-label" for="response-check-${aref.data('count')}">Is Correct</label>
                    </div>
                </div>
            </div>
            `
        );
    });

    //Click add theory link
    $j(document).on('click', '#addTheoryModal', function (event) {
        var btn = $j(event.target);
        var unitID = btn.data('uid');
        $j("#btn-add-theory").data('uid', unitID);
    });

    //Add theory content
    $j(document).on('click', '#btn-add-theory', function(event) {
        event.preventDefault();
        var btn = $j(event.target);
        var unitID = btn.data('uid');  
        var titleLink  = $j('#add-theory-title').val();
        var link  = $j('#add-theory-link').val();

        $j.ajax({
            type: "POST",
            url: "/ajax/builder/add-theory.php",
            dataType: 'text',
            data: { 
                unitID:     unitID, 
                title:      titleLink,
                link:       link
            },
            beforeSend  : function() {
                //Show loading icon..
                $j("#btn-add-theory").prop('disabled', true);
                $j("#btn-add-theory").text('Loading...');
            },
            success: function(result) {
                var data = JSON.parse(result);
                $j("#theory-list-" + data.unitID).append(`<p><a href="${data.link}" target="_blank">${data.title}</a></p>`);
                $j("#addTheoryDialog").modal("hide");
                $j("#btn-add-theory").prop('disabled', false);
                $j("#btn-add-theory").text('Add');
            },
            error: function(result) {
                console.log("ERROR:");
                console.log(result);
                $j("#addTheoryDialog").modal("hide");
                $j("#btn-add-theory").prop('disabled', false);
                $j("#btn-add-theory").text('Add');
            }
        });
    });


        //Click add INFO link
        $j(document).on('click', '#addInfoModal', function (event) {
            var btn = $j(event.target);
            var unitID = btn.data('uid');
            $j("#btn-add-info").data('uid', unitID);
        });
    
        //Add INFO content
        $j(document).on('click', '#btn-add-info', function(event) {
            event.preventDefault();
            var btn = $j(event.target);
            var unitID = btn.data('uid');  
            var title  = $j('#add-info-title').val();
            var info  = $j('#add-info-link').val();
    
            $j.ajax({
                type: "POST",
                url: "/ajax/builder/add-info.php",
                dataType: 'text',
                data: { 
                    unitID:     unitID, 
                    title:      title,
                    info:       info
                },
                beforeSend  : function() {
                    //Show loading icon..
                    $j("#btn-add-info").prop('disabled', true);
                    $j("#btn-add-info").text('Loading...');
                },
                success: function(result) {
                    var data = JSON.parse(result);
                    $j("#info-list-" + data.unitID).append(`<h5>${data.title}</h5><p>${data.info}</p>`);
                    $j("#addInfoDialog").modal("hide");
                    $j("#btn-add-info").prop('disabled', false);
                    $j("#btn-add-info").text('Add');
                },
                error: function(result) {
                    console.log("ERROR:");
                    console.log(result);
                    $j("#addInfoDialog").modal("hide");
                    $j("#btn-add-info").prop('disabled', false);
                    $j("#btn-add-info").text('Add');
                }
            });
        });
});