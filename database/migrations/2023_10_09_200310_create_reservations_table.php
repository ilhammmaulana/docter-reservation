    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateReservationsTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('reservations', function (Blueprint $table) {
                $table->uuid('id')->primary()->index();
                $table->text('remarks');
                $table->enum('status', ['hold', 'cancel', 'verify', 'arrived', 'done'])->default('hold');
                $table->foreignUuid('docter_id')->constrained('docters', 'id');
                $table->foreignUuid('created_by')->constrained('users', 'id');
                $table->integer('queue_number')->nullable();
                $table->text('remark_cancel')->nullable();
                $table->timestamp('verify_at')->nullable();
                $table->timestamp('done_at')->nullable();
                $table->timestamp('time_arrival')->nullable();
                $table->timestamp('time_reservation')->nullable();
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('reservations');
        }
    }
