<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PetResource\Pages;
use App\Filament\Resources\PetResource\RelationManagers;
use App\Models\Pet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PetResource extends Resource
{
    protected static ?string $model = Pet::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
    
                Forms\Components\TextInput::make('hunger')
                    ->numeric()
                    ->default(100)
                    ->required(),
    
                Forms\Components\TextInput::make('health')
                    ->numeric()
                    ->default(100)
                    ->required(),
    
                Forms\Components\TextInput::make('energy')
                    ->numeric()
                    ->default(100)
                    ->required(),
    
                Forms\Components\TextInput::make('cleanliness')
                    ->numeric()
                    ->default(100)
                    ->required(),
    
                Forms\Components\TextInput::make('happiness')
                    ->numeric()
                    ->default(100)
                    ->required(),
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Имя'),
                Tables\Columns\TextColumn::make('hunger'),
                Tables\Columns\TextColumn::make('health'),
                Tables\Columns\TextColumn::make('energy'),
                Tables\Columns\TextColumn::make('cleanliness'),
                Tables\Columns\TextColumn::make('happiness'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
            
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPets::route('/'),
            'create' => Pages\CreatePet::route('/create'),
            'edit' => Pages\EditPet::route('/{record}/edit'),
        ];
    }
}