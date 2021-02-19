<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // $this->call(UsersTableSeeder::class);
        $this->call([
            ProfessionsTableSeeder::class,
            QualificationCategoriesTableSeeder::class,
            RenewalCategoriesTableSeeder::class,
            RegisterCategoriesTableSeeder::class,
            MaritalStatusesTableSeeder::class,
            GendersTableSeeder::class,
            TitlesTableSeeder::class,
            IdentificationCategoriesTableSeeder::class,
            RolesTableSeeder::class,
            SystemEntitiesTableSeeder::class,
            RenewalStatusesTableSeeder::class,
            OperationalStatusesTableSeeder::class,
            ProvincesTableSeeder::class,
            NationalitiesTableSeeder::class,
            PaymentMethodsTableSeeder::class,
            DocumentCategoriesTableSeeder::class,
            CitiesTableSeeder::class,
            PractitionerRegistrationFeesTableSeeder::class,
            StudentRegistrationFeesTableSeeder::class,
            AccreditedInstitutionsTableSeeder::class,
            QualificationLevelsTableSeeder::class,
            RenewalFeesTableSeeder::class,
            PrefixesTableSeeder::class,
            CdPointsTableSeeder::class,
            ProfessionalQualificationTableSeeder::class,
            AccreditedQualificationsTableSeeder::class,
            PaymentTypeTableSeeder::class,
            PaymentChannelTableSeeder::class,
            RenewalPeriodsTableSeeder::class,
            DiscreditedInstitutionsTableSeeder::class,
            PaymentItemsTableSeeder::class,
            /*PaymentItemFeeTableSeeder::class,*/
            PaymentItemsCategoryTableSeeder::class,
            RequirementsTableSeeder::class,
            UsersTableSeeder::class,
            VatTableSeeder::class,

        ]);


    }
}
