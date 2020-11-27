<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
    use Symfony\Component\Console\Output\ConsoleOutput;

    class CreateFitLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $consoleOutput = new ConsoleOutput();
        Schema::create('fit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("fit_root_id");
            $table->unsignedBigInteger('fit_it');
            $table->string("event");
            $table->timestamp('created_at')->useCurrent();

            $table->foreign("fit_it")->references("ID")->on("fits");
            $table->foreign("fit_root_id")->references("ID")->on("fits");
        });
        $consoleOutput->writeln("Created fit_logs table");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fit_logs');
    }
}
