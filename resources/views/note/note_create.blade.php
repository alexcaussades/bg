<?php 
use Carbon\Carbon;
?>

@extends("exention.header")
@extends("exention.navbar")
@section("content")

<div class="container mt-5">
    <form action="#" method="post">
        @csrf
        <div class="form-group">
            <label for="note" class="fs-5">Ajout d'une Note: {{ $puit[0]->Name }}</label>
            <select name="info_classic"  class="form-control mt-2" id="info">
                <optgroup label="Courant">
                    <option selected value="Changement de berg">Changement de berg</option>
                    <option value="Refaire étanchéité du puit">Refaire étanchéité du puit</option>
                </optgroup>
                <optgroup label="Vanne">
                    <option value="Changement de vanne">Changement de vanne</option>
                    <option selected ="Mauvaise étanchéité de la vanne">Mauvaise étanchéité de la vanne</option>
                </optgroup>
                <optgroup label="Prise d'échantillon">
                    <option value="Changer la prise d'échantillon"> Changer la prise d'échantillon </option>
                    <option value="Changer le bouchon sur la prise d'echantillon">Changer le bouchon sur la prise d'echantillon</option>
                    <option value="Mauvaise étanchéité de la prise d'échantillon">Mauvaise étanchéité de la prise d'échantillon</option>
                    <option value="Mauvais diamètre sur la prise échantillon">Mauvais diamètre sur la prise échantillon</option>
                </optgroup>
                <option value="autre" id="autre">Autre</option>
                <textarea class="form-control mt-2" name="info" id="text" cols="30" rows="10"></textarea>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Ajouter</button>
    </form>
</div>


<script>
    document.getElementById("text").style.display = "none";
    // faire afficher le textarea si l'utilisateur dans la liste déroulante id info choisi autre
    document.getElementById("info").addEventListener("change", function(){
        if(document.getElementById("info").value == "autre"){
            document.getElementById("text").style.display = "block";
        }else{
            document.getElementById("text").style.display = "none";
        }
    });
</script>

@endsection

