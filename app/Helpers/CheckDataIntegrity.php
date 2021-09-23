<?php

use App\Models\Role;
use App\Models\Address\Address;
use App\Models\PartsDemand;
use App\Models\ContactInformation;
use App\Models\User;

if (!function_exists('check_integrity')) {
    function check_integrity(string $class, int $searchId, $user = false)
    {
        switch ($class) {
            case 'App\Models\Address\Address': {
                    $address = Address::find($searchId);
                    if ($address == null) {
                        dd('aqui');
                        return response()->json([
                            'success' => false,
                            'message' => 'Address not found.'
                        ], 404);
                    } elseif ($user && $address->user_id !== $user->id) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Address does not belong to user.'
                        ], 403);
                    } elseif (!$address->active) {
                        return response()->json(
                            [
                                'success' => false,
                                'message' => 'Address not found.'
                            ],
                            404
                        );
                    }
                    return false;
                }
            case 'App\Models\PartsDemand': {
                    $demand = PartsDemand::find($searchId);
                    if ($demand == null) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Demand not found.'
                        ], 404);
                    } elseif ($user && $demand->user_id !== $user->id && !$user->hasRole('ADMINISTRATOR')) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Demand does not belong to user.'
                        ], 403);
                    }
                    return false;
                }
            case 'App\Models\Role': {
                    $role = Role::find($searchId);
                    if ($role == null) {
                        return response()->json(
                            [
                                'success' => false,
                                'message' => 'Role not found.'
                            ],
                            404
                        );
                    }
                    return false;
                }
            case 'App\Models\ContactInformation': {
                    $contactInformation = ContactInformation::find($searchId);
                    if ($contactInformation == null) {
                        return response()->json(
                            [
                                'success' => false,
                                'message' => 'Contact information not found.'
                            ],
                            404
                        );
                    } elseif ($contactInformation->user_id !== $user->id) {
                        return response()->json(
                            [
                                'success' => false,
                                'message' => 'Contact information does not belong to user.'
                            ],
                            403
                        );
                    }
                    return false;
                }
            case 'App\Models\User': {
                    $userDb = User::find($searchId);
                    $user->assignRole('ADMINISTRATOR');
                    if ($userDb == null) {
                        return response()->json(
                            [
                                'success' => false,
                                'message' => 'User not found.'
                            ],
                            404
                        );
                    } elseif ($userDb->id !== $user->id && !$user->hasRole('ADMINISTRATOR')) {
                        return response()->json(
                            [
                                'success' => false,
                                'message' => 'Access denied.'
                            ],
                            403
                        );
                    }
                    return false;
                }
            default:
                return response()->json([
                    'success' => false,
                    'message' => 'Model not found.'
                ], 404);
        }
    }
}
