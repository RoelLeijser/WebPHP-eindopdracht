<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Elibyy\TCPDF\Facades\TCPDF;
use App\Models\User;
use App\Models\Contract;
use App\Rules\ContractRule;
use Illuminate\Support\Facades\Storage;

class ContractController extends Controller
{
    public function export($id) 
    {
        $pdf = new TCPDF;
        $account = User::findOrFail($id);

        if (!Storage::exists('storage/contracts')) {
            Storage::makeDirectory('storage/contracts');
        }


        if(!is_null($account->contract)) 
        {
            $path = $account->contract->contract;
        } 
        else {
            $filename = 'contract-'.$account->id.'.pdf';
            $path = 'storage' . DIRECTORY_SEPARATOR . 'contracts' . DIRECTORY_SEPARATOR . $filename;
            $data = [
                'name' => $account->name,
                'email' => $account->email,
            ];
    
            $view = \View::make('contract', $data);
            $html = $view->render();
            
            $pdf::SetTitle('Contract');
            $pdf::AddPage();
            $pdf::writeHTML($html, true, false, true, false, '');
            $pdf::Output(public_path($path), 'F');

            Contract::create(['contract' => $path, 'user_id' => $account->id]);
        }
        return response()->download(public_path($path));
    }

    public function verify(Request $request, $id)
    {
        $request->validate([
            'contract' => ['required', 'mimes:pdf', 'file', 'max:2048', new ContractRule],
        ]);

        try {
            $account = User::findOrFail($id);

            $file = $request->file('contract');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('contracts', $fileName, 'public');
            $account->givePermissionTo(['contract accepted']);

            return redirect()->route('account.index')->with('success', __('account.contract_success'));
        }
        catch(Exception $e) {
           return redirect()->route('account.edit', $id)->with('error', __('account.contract_fail'));
        }
    }
}
