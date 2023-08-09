<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $path = resource_path('/dev_tools/currency.sql');
        DB::unprepared(file_get_contents($path));

        $path2 = resource_path('/dev_tools/openai_table.sql');
        DB::unprepared(file_get_contents($path2));

        $path3 = resource_path('/dev_tools/openai_chat_categories_table.sql');
        DB::unprepared(file_get_contents($path3));

        $path4 = resource_path('/dev_tools/openai_filters.sql');
        DB::unprepared(file_get_contents($path4));

        $path5 = resource_path('/dev_tools/frontend_tools.sql');
        DB::unprepared(file_get_contents($path5));

        $path6 = resource_path('/dev_tools/faq.sql');
        DB::unprepared(file_get_contents($path6));

        $path7 = resource_path('/dev_tools/frontend_future.sql');
        DB::unprepared(file_get_contents($path7));

        $path8 = resource_path('/dev_tools/howitworks.sql');
        DB::unprepared(file_get_contents($path8));

        $path9 = resource_path('/dev_tools/testimonials.sql');
        DB::unprepared(file_get_contents($path9));

        $path10 = resource_path('/dev_tools/frontend_who_is_for.sql');
        DB::unprepared(file_get_contents($path10));

        $path11 = resource_path('/dev_tools/frontend_generators.sql');
        DB::unprepared(file_get_contents($path11));

        $path12 = resource_path('/dev_tools/clients.sql');
        DB::unprepared(file_get_contents($path12));

        $path13 = resource_path('/dev_tools/health_check_result_history_items.sql');
        DB::unprepared(file_get_contents($path13));

        $this->command->info('Currency table seeded!');
    }
}
