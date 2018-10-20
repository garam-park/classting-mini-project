<?php

use Flynsarmy\CsvSeeder\CsvSeeder;

class DevUsersTableSeeder extends CsvSeeder {

	public function __construct()
	{
		$this->table = 'users';
        $this->filename = base_path().'/database/seeds/csvs/dev-users.csv';
		$this->offset_rows = 1;
		$this->mapping = [
			0 => 'id',
			1 => 'name',
			2 => 'email',
			3 => 'email_verified_at',
			4 => 'password',
			5 => 'remember_token',
			6 => 'created_at',
			7 => 'updated_at',
		];
	}

	public function run()
	{
		// Recommended when importing larger CSVs
		DB::disableQueryLog();

		// Uncomment the below to wipe the table clean before populating
		// DB::table($this->table)->truncate();

		parent::run();
	}
}