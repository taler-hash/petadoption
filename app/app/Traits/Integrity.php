<?php

namespace App\Traits;

trait Integrity
{
    private function checkIntegrity($model, $request, $callback, $options) {
        $model = $model::find($request->id);
        $matchedRecord = true;
        $integrity = $options['integrity'] ?? false;
        $exist = $options['exist'] ?? false;
        $toExcludeInputs = $options['toExcludeInputs'] ?? false;
        $client = $options['client'] ?? false;

        if($model && $integrity) {
            foreach($model->getAttributes() as $key => $value) {
                $excludedInputs = ['created_at', 'updated_at'];

                if($toExcludeInputs && is_array($toExcludeInputs)) {
                    $excludedInputs = array_merge($excludedInputs, $toExcludeInputs);
                }
    
                if(!in_array($key, $excludedInputs) && $request->{$key} != $value) {
                    $matchedRecord = false;
                    break;
                } 
            }
        }
        if(($exist || $integrity) && ($model && $matchedRecord)) {
            return $callback();
        } else {
            if($client === 'axios') {
                return response()->json(['message' => 'current record is outdated'], 422);
            }
            return redirect()->back()->withErrors(['message' => 'current record is outdated'])->withInput();
        }
    }
}