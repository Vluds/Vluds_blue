<div id="addPublication" class="box">
	<div id="cross"><img src="img/cross.png"></div>
	<h2>Ajouter une création</h2>
	<div id="container">
		<ul>
			<li id="artwork-container">
				<div id="artworkImg">
						
				</div>

				<div id="addArtwork">
				</div>

				<input id="artwork-upload" name="artwork-upload" type="file"></input>
			</li>
			<li id="submit-cover-container">
				<p>Optionel: </p>
				<input id="submit-cover" name="submit-cover" type="submit" value="Ajouter un aperçu"></input>
				<input id="artwork-cover-upload" name="artwork-cover-upload" accept="image/*" type="file"></input>
			</li>
		</ul>
		<ul>
			<li>
				<input id="artworkName" name="artworkName"  type="text" placeholder="Donner un nom à la création"/>
			</li>
		</ul>
		<ul>
			<li>
				<textarea id="artworkDesc" name="artworkDesc" placeholder="Donner une description"></textarea>
			</li>
		</ul>

		<ul>
			<li>
				<input id="artworkTags" name="artworkTags" type="text" placeholder="Ajouter des tags séparés par un espace"></input>
			</li>
		</ul>

		<ul>
			<li id="submit-artwork-container">
				<input id="submit-artwork" name="submit-artwork" type="submit" value="Ajouter"/>
			</li>
		</ul>
	</div>
</div>