<?php

use Speciphy\Framework\Recorder\QuietTestRecorder;

class When_all_tests_pass_in_a_context
{
    function given_a_test_recorder()
    {
        $this->recorder = new QuietTestRecorder();
        ob_start();
    }

    function because_we_record_the_results_of_a_successful_test_suite()
    {
        $this->recorder->recordSuiteStart();
        $this->recorder->recordContextStart("My_special_context");

        $this->recorder->recordAssertionStart("it_Should_be_wonderful");
        $this->recorder->recordAssertionEnd();

        $this->recorder->recordAssertionStart("it_Should_be_marvellous");
        $this->recorder->recordAssertionEnd();
        
        $this->recorder->recordAssertionStart("it_Should_be_successful");
        $this->recorder->recordAssertionEnd();

        $this->recorder->recordContextEnd();
        $this->recorder->recordSuiteEnd();
    }

    function it_should_output_a_single_dot_per_test()
    {
        expect(ob_get_contents(),
            startsWith("...\n")
        );
    }

    function it_should_output_PASSED()
    {
        expect(ob_get_contents(),
            containsString("PASSED!" . PHP_EOL));
    }

    function it_should_output_the_summary_line()
    {
        expect(ob_get_contents(),
            containsString("1 contexts, 3 assertions")
        );
    }

    function cleanup_stdout()
    {
        ob_end_clean();
    }
}


class When_an_assertion_fails
{
    function given_a_test_recorder()
    {
        $this->recorder = new QuietTestRecorder();
        ob_start();
    }

    function because_we_record_the_results_of_a_successful_test_suite()
    {
        $this->recorder->recordSuiteStart();
        $this->recorder->recordContextStart("My_special_context");

        $this->recorder->recordAssertionStart("it_Should_be_wonderful");
        $this->recorder->recordAssertionEnd();

        $this->recorder->recordAssertionStart("it_should_be_marvellous");
        $this->recorder->recordAssertionEnd(new ExpectationException("expected marvels, but was not marvellous"));
        
        $this->recorder->recordAssertionStart("it_Should_be_successful");
        $this->recorder->recordAssertionEnd();

        $this->recorder->recordContextEnd();
        $this->recorder->recordSuiteEnd();
    }

    function it_should_output_a_dot_for_success_and_an_F_for_failure()
    {
        expect(ob_get_contents(),
            startsWith(".F." . PHP_EOL)
        );
    }

    function it_should_output_FAILED()
    {
        expect(ob_get_contents(),
            containsString("FAILED!" . PHP_EOL)
        );
    }

    function it_should_list_failures()
    {
        expect(ob_get_contents(),
            containsString("My special context: it should be marvellous" . PHP_EOL . "\t" . "expected marvels, but was not marvellous"));
    }

    
    function cleanup_stdout()
    {
        ob_end_clean();
    }
}
