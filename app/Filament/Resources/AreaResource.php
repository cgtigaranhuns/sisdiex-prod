<?php

namespace App\Filament\Resources;

//teste do git 2

use App\Filament\Resources\AreaResource\Pages;
use App\Filament\Resources\AreaResource\RelationManagers;
use App\Models\Area;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AreaResource extends Resource
{
    protected static ?string $model = Area::class;

    protected static ?string $navigationIcon = 'heroicon-s-squares-plus';

    protected static ?string $navigationLabel = 'Áreas';

    protected static ?string $modelLabel = 'área';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('cod_area')
                    ->label('Código da Área')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nome')
                    ->label('Nome')
                    ->required()
                    ->maxLength(255),
                Radio::make('tipo')
                    ->required()
                    ->options([
                        '1' => 'Extensão',
                        '2' => 'Conhecimento',
                        '3' => 'Temática',
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cod_area')
                    ->label('Código da Área')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
                    
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAreas::route('/'),
        ];
    }    
}
