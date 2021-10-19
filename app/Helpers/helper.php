<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('customResponse')) {

    function customResponse($data = [], $code = 200, $error = "")
    {
        return response()->json([
            'data'  => $data,
            'code'  => $code,
            'error' => $error
        ], $code);
    }
}


if (!function_exists('exportData')) {

    function exportData($name, $object)
    {
        $file = \Maatwebsite\Excel\Facades\Excel::store($object, '/public/exports/'.$name);
        return asset('storage/exports/'.$name);
    }
}

if (!function_exists('dropView')) {

    function dropView($name)
    {
        return \Illuminate\Support\Facades\DB::statement("DROP VIEW IF EXISTS $name");
    }
}

if (!function_exists('createView')) {

    function createView()
    {
        return \Illuminate\Support\Facades\DB::statement("CREATE VIEW transactions_view
            AS
            SELECT
                loan_transactions.id as id,
                loan_transactions.type as transaction_type,
                clients.type as client_type,
                loan_transactions.created_at,
                agents.first_name as agent_first_name,
                agents.id as agent_id,
                clients.id as client_id,
                agents.last_name as agent_last_name,
                clients.first_name as client_first_name,
                clients.last_name as client_last_name,
                clients.first_name as merchant_first_name,
                clients.last_name as merchant_last_name
                FROM loan_transactions
                LEFT JOIN agents ON loan_transactions.agent_id = agents.id
                LEFT JOIN clients ON loan_transactions.client_id = clients.id
                OR
                loan_transactions.merchant_id = clients.id
        ");
    }
}

if (!function_exists('createActiveBaseView')) {

    function createActiveBaseView()
    {
        return \Illuminate\Support\Facades\DB::statement("CREATE VIEW active_base_view
            AS
            SELECT
                loan_transactions.id as id,
                loan_transactions.type as transaction_type,
                clients.type as client_type,
                loan_transactions.created_at,
                agents.first_name as agent_first_name,
                agents.id as agent_id,
                clients.id as client_id,
                agents.last_name as agent_last_name,
                clients.first_name as client_first_name,
                clients.last_name as client_last_name,
                clients.first_name as merchant_first_name,
                clients.last_name as merchant_last_name
                FROM loan_transactions
                LEFT JOIN agents ON loan_transactions.agent_id = agents.id
                LEFT JOIN clients ON loan_transactions.client_id = clients.id
                OR
                loan_transactions.merchant_id = clients.id
        ");
    }
}

if (!function_exists('createRevenueView')) {

    function createRevenueView()
    {
        return \Illuminate\Support\Facades\DB::statement("CREATE VIEW revenue_view
            AS
            SELECT
                clients.id as client_id,
                clients.type as client_type,
                clients.first_name as client_first_name,
                clients.last_name as client_last_name,
                agents.first_name agent_first_name,
                agents.last_name as agent_last_name
                FROM clients
                INNER JOIN agents
        ");
    }
}

if (!function_exists('checkFileType')) {

    function checkFileType($file)
    {
        if (in_array($file, ['pdf'])){
            return 'pdf';
        }elseif (in_array($file, ['jpg', 'jpeg', 'png', 'GIF', 'tiff'])){
            return 'image';
        }else{
            return $file;
        }
    }
}
