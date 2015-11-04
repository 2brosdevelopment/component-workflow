<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateWorkflowTables extends Migration
    {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {

            Schema::create( 'nodes', function ( Blueprint $table ) {

                $table->increments( 'id' );
                $table->string( 'name', 200 );
                $table->string( 'display_name', 200 );
                $table->text( 'description' );
                $table->string( 'job_class', 200 );
                $table->timestamps();
                $table->integer( 'created_by' )->unsigned();
                $table->integer( 'modified_by' )->unsigned();
                $table->unique( 'name' );
                $table->index( 'job_class' );
            } );

            Schema::create( 'workflows', function ( Blueprint $table ) {

                $table->increments( 'id' );
                $table->string( 'name', 200 );
                $table->string( 'display_name', 200 );
                $table->text( 'description' );
                $table->timestamps();
                $table->integer( 'created_by' )->unsigned();
                $table->integer( 'modified_by' )->unsigned();
                $table->softDeletes();
                $table->unique( 'name' );

            } );
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {

            Schema::dropIfExists( 'nodes' );
            Schema::dropIfExists( 'workflows' );
        }
    }
