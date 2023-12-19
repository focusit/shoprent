<? 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            // $table->decimal('bill_amount', 8, 2);
            $table->date('due_date');
            // $table->decimal('previous_balance', 8, 2)->default(0);
            $table->decimal('penalty', 8, 2)->default(0);
            $table->decimal('discount', 8, 2)->default(0);
            $table->timestamps(); 
            // $table->string('status')->default('unpaid');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
