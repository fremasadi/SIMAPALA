<?php

namespace App\Filament\Resources\Pembayarans\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PembayaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('transaksi_id')
                    ->relationship('transaksi', 'id')
                    ->required(),
                TextInput::make('order_id')
                    ->required(),
                TextInput::make('transaction_id')
                    ->default(null),
                TextInput::make('gross_amount')
                    ->required()
                    ->numeric(),
                Select::make('payment_type')
                    ->options([
            'credit_card' => 'Credit card',
            'bank_transfer' => 'Bank transfer',
            'echannel' => 'Echannel',
            'gopay' => 'Gopay',
            'qris' => 'Qris',
            'shopeepay' => 'Shopeepay',
            'other' => 'Other',
        ])
                    ->default(null),
                TextInput::make('bank')
                    ->default(null),
                TextInput::make('va_number')
                    ->default(null),
                Select::make('transaction_status')
                    ->options([
            'pending' => 'Pending',
            'settlement' => 'Settlement',
            'capture' => 'Capture',
            'deny' => 'Deny',
            'cancel' => 'Cancel',
            'expire' => 'Expire',
            'failure' => 'Failure',
        ])
                    ->default('pending')
                    ->required(),
                Textarea::make('fraud_status')
                    ->default(null)
                    ->columnSpanFull(),
                DateTimePicker::make('transaction_time'),
                DateTimePicker::make('settlement_time'),
                Textarea::make('payment_url')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('midtrans_response')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
