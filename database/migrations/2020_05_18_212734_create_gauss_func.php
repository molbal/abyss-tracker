<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;

class CreateGaussFunc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        DROP FUNCTION IF EXISTS gaussCdf;

DELIMITER //
CREATE FUNCTION gaussCdf(mean float, stdev float, x float) RETURNS float DETERMINISTIC
BEGIN
	set @z = (x - mean) / stdev;

	set @b1 = 0.319381530;
	set @b2 = -0.356563782;
	set @b3 = 1.781477937;
	set @b4 = -1.821255978;
	set @b5 = 1.330274429;
	set @p = 0.2316419;
	set @c = 0.39894228;

	IF @z >= 0.0 THEN
		set @t = 1.0 / ( 1.0 + @p * @z );
		return (1.0 - @c * exp(-@z * @z / 2.0) * @t * ( @t * ( @t * ( @t * ( @t * @b5 + @b4 ) + @b3 ) + @b2 ) + @b1 ));
	ELSE
		set @t = 1.0 / ( 1.0 - @p * @z );
		return ( @c * exp(-@z * @z / 2.0) * @t * ( @t * ( @t * ( @t * ( @t * @b5 + @b4 ) + @b3 ) + @b2 ) + @b1 ));
	END IF;

END
//
DELIMITER ;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("
        DROP FUNCTION IF EXISTS gaussCdf;
        ");
    }
}
