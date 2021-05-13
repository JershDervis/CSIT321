<?php require_once('includes/header.php');

$qa = array(
    'Is account registration required?'  =>  'Account registration at <strong>' . SITE_NAME . '</strong> is required if you wish to attempt any quizzes or access any of our learnable content',
    'Is it free to sign up?'    =>  'You can register an account today for free! Click <a href="register.php">here</a> to start the sign up process.',
    'Who sets the Driving Theory Test?' =>  'The Theory Test is set by the Transport for NSW; a government body responsible for driver education.',
    'How much does the Driving Theory Test cost?'   =>  'The current Theory Test fee for car drivers in the UK is £23.',
    'Where do I sit my Theory Test?'    =>  'You will sit your test in a designated official Transport for NSW Theory Test centre.',
    'How is the Theory Test taken?' =>  'The Theory Test is taken on a computer at an official Transport for NSW test centre and consists of two individual tests which must both be taken on the same day.
    The first is a multiple-choice test based on the rules of the road, as set by the DVSA, and the second is a Hazard Perception Test',
    'What is the pass mark for the car Theory Test?'    =>  'The current pass mark for learner car drivers in NSW is 43 or more out of 50.
    For the Hazard Perception section of the test, you need to score 44 out of 75. 
    The current pass rate is only 47.3%, meaning that over half of everyone who takes the Theory Test WILL FAIL!
    This is why it\'s so important to thoroughly revise and practise!',
    'How do I pass my car Theory Test the first time?'  =>  'There is a simple answer to this question. Revise, revise, revise!',
    'What do I have to do to pass the Theory Test?' =>  'For the multiple-choice test, you will be required to answer 50 questions covering topics that include alertness, attitude, safety, road signs, and much more.
    You will be allocated 57 minutes to complete the first part of your Theory Test and you must get at least 43 questions correct to pass.
    Before the Theory Test begins you’ll be given full instructions on how the test works. It’s important to listen carefully so you know what to expect and can react accordingly.
    You also have the option of going through a practice session of the multiple-choice questions to get used to the layout of the test.
    If you choose to do this, your real Theory Test will begin at the end of your practice session.',
    'What sort of questions will I be asked?'   =>  'You’ll be asked questions taken from the 14 official question categories set by the Transport for NSW.
    These are; Accidents, Alertness, Attitude, Documents, Hazard Awareness, Motorway Rules, Other Types of Vehicle, Road and Traffic Signs, Rules of the Road, Safety and Your Vehicle, Safety Margins, Vehicle Handling and Vulnerable Road Users.
    In total there are 730 Driving Theory Test questions for car drivers that you could be asked, so it’s wise to get in as much practise as you possibly can!',
    'What happens if I arrive late at the Theory Test centre?'  =>  'Before your test, you are given a 15-minute window of time to arrive at the test centre. So long as you arrive during this allocated time period you will be allowed to take the test.
    If you do arrive late you WILL NOT be allowed into the exam room as this will distract the other candidates and you WILL lose your fee.',
    'What happens on the Driving Theory Test?'  =>  'During the test, a question and several possible answers will appear onscreen and you have to select the correct answer by touching the screen.
    Some questions may require more than one answer, so it’s important to read the questions carefully.
    You can navigate between questions and ‘flag’ questions that you want to come back to later in the test.
    The last five questions will be linked to a Theory Test case study. The subject of the scenario focuses on real-life examples and experiences that drivers could come across when driving.
    After the multiple-choice part, you can choose to have a break of up to three minutes before the Hazard Perception Test starts.
    The Hazard Perception Test is basically an interactive video test where you have to scan different road settings from a driver’s viewpoint and identify hazards as soon as they develop',
    'How difficult is the Driving Theory Test?' =>  'This is a tricky question to answer as it depends on how much you practise beforehand, but on average, around one in three people will fail their Theory Test.
    It also depends on the quality of your learning materials, especially when it comes to the Hazard Perception part of the test.
    The Hazard Perception Test is considered by many to be more difficult than the multiple-choice part because there is no way of previewing the actual video clips before your test.',
    'How long is the Theory Test certificate/letter valid for?' =>  'Your Theory Test certificate is valid for 2 years from the date of issue.',
    'If I fail my Theory Test, when can I rebook?'  =>  'You will need to wait at least three clear working days before you are able to re-book your Theory Test.',
    'I’ve lost my Driving Theory Test certificate, what should I do?'   =>  'You will need to contact the Transport for NSW if you have lost your Theory Test certificate. They will not be able to issue a replacement certificate but they will send you a letter containing your certificate number.',
    'When to book a driving theory test'    =>  'We recommend making sure you’re prepared before you book your theory test. With a combination of practical driving experience, input from your instructor and consistent revision from a good quality textbook or website, you’ll soon feel confident enough to give it a shot. Unsure if the time is right for you? Your instructor will be more than happy to advise you whether a little more study is needed.'
);

?>

<div id="container-white">
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center" color="black">FAQS</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel-group" id="accordion">
                    <div class="faqHeader"><h5>General questions</h5></div>
                        <?php
                        for($x = 0; $x < sizeof($qa); $x++) {
                            $curQuestion = array_keys($qa)[$x];
                            $curAnswer = $qa[$curQuestion];
                            echo '
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse' . $x . '">' . $curQuestion . '</a>
                                    </h4>
                                </div>
                                <div id="collapse' . $x . '" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        ' . $curAnswer . '
                                    </div>
                                </div>
                            </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('includes/footer.php'); ?>
