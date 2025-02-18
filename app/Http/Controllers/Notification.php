<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseDatabase;
use Redirect;

class Notification extends Controller
{
    protected $firebaseDatabase;

    public function __construct(FirebaseDatabase $firebaseDatabase)
    {
        $this->firebaseDatabase = $firebaseDatabase;
    }

    public function read(Request $request)
    {
        $key = $request->query('key');
        $url = $request->query('url');
        $this->firebaseDatabase->update("notifications/admin/$key", [
            'read_at' => now()->format('Y-m-d H:i:s'),
        ]);

        return redirect()->to($url);
    }

    public function delete(Request $request)
    {
        $key = $request->query('key');
        $url = $request->query('url');
        $this->firebaseDatabase->delete("notifications/admin/$key");
        return redirect()->to($url);
    }
}
