<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
    use Symfony\Component\Console\Output\ConsoleOutput;

    class CreateFitQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $consoleOutput = new ConsoleOutput();
        Schema::create('fit_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fit_id')->index();
            $table->bigInteger('char_id');
            $table->mediumText('question');
            $table->timestamps();

            $table->foreign("fit_id")->references("ID")->on("fits");
            $table->foreign("char_id")->references("CHAR_ID")->on("chars");
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
        Schema::dropIfExists('fit_questions');
    }
}
