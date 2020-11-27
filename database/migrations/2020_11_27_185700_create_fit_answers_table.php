<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
    use Symfony\Component\Console\Output\ConsoleOutput;

    class CreateFitAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $consoleOutput = new ConsoleOutput();
        Schema::create('fit_answers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('char_id');
            $table->unsignedBigInteger('question_id');
            $table->mediumText('text');
            $table->timestamps();

            $table->foreign("char_id")->references("CHAR_ID")->on("chars");
            $table->foreign("question_id")->references("id")->on("fit_questions");
        });
        $consoleOutput->writeln("Created fit_questions table");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fit_answers');
    }
}
