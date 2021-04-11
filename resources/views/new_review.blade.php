<x-layout>
  <x-slot name="title">
    Nouvelle critique de [nom de l'anime]
  </x-slot>

  <h1>Nouvelle Critique de {{$anime->title}}</h1>

  <div>
    <img style="width: 200px;"alt="" src="/covers/{{ $anime->cover }}" />
  </div>

  <form method="post">
    @csrf
    <p>Critique :</p>
    <textarea name="critic" rows="4" cols="50">
      Ecrivez votre Critique ici !
    </textarea>
    <label for="quantity">Note de 0 à 10:</label><input type="number" id="grade" name="grade" min="0" max="10"><br>
    <input type="submit" value="Valider !">
  </form>
</x-layout>
