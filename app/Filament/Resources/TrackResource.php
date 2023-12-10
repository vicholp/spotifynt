<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrackResource\Pages;
use App\Models\Track;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class TrackResource extends Resource
{
    protected static ?string $model = Track::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('release_id')
                    ->required(),
                Forms\Components\TextInput::make('mb_recording_id')
                    ->required()
                    ->maxLength(500),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(1000),
                Forms\Components\TextInput::make('track_position'),
                Forms\Components\TextInput::make('length'),
                Forms\Components\TextInput::make('average_loudness'),
                Forms\Components\TextInput::make('bpm'),
                Forms\Components\TextInput::make('danceable'),
                Forms\Components\TextInput::make('genre_rosamerica')
                    ->maxLength(100),
                Forms\Components\TextInput::make('language')
                    ->maxLength(10),
                Forms\Components\TextInput::make('mood_acoustic'),
                Forms\Components\TextInput::make('mood_aggressive'),
                Forms\Components\TextInput::make('mood_electronic'),
                Forms\Components\TextInput::make('mood_happy'),
                Forms\Components\TextInput::make('mood_party'),
                Forms\Components\TextInput::make('mood_relaxed'),
                Forms\Components\TextInput::make('mood_sad'),
                Forms\Components\TextInput::make('moods_mirex')
                    ->maxLength(100),
                Forms\Components\TextInput::make('voice_instrumental')
                    ->maxLength(100),
                Forms\Components\TextInput::make('mb_data')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('release_id'),
                Tables\Columns\TextColumn::make('mb_recording_id'),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('track_position'),
                Tables\Columns\TextColumn::make('length'),
                Tables\Columns\TextColumn::make('average_loudness'),
                Tables\Columns\TextColumn::make('bpm'),
                Tables\Columns\TextColumn::make('danceable'),
                Tables\Columns\TextColumn::make('genre_rosamerica'),
                Tables\Columns\TextColumn::make('language'),
                Tables\Columns\TextColumn::make('mood_acoustic'),
                Tables\Columns\TextColumn::make('mood_aggressive'),
                Tables\Columns\TextColumn::make('mood_electronic'),
                Tables\Columns\TextColumn::make('mood_happy'),
                Tables\Columns\TextColumn::make('mood_party'),
                Tables\Columns\TextColumn::make('mood_relaxed'),
                Tables\Columns\TextColumn::make('mood_sad'),
                Tables\Columns\TextColumn::make('moods_mirex'),
                Tables\Columns\TextColumn::make('voice_instrumental'),
                Tables\Columns\TextColumn::make('mb_data'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListTracks::route('/'),
            'create' => Pages\CreateTrack::route('/create'),
            'edit' => Pages\EditTrack::route('/{record}/edit'),
        ];
    }
}
