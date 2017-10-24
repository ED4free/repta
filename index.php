<?php
require_once( "./includes/ContentManager.php" );

$assocFiles = scandir( "./text");
$contentMan = new ContentManager();

if ( ! empty( $_GET[ "lang" ] ) ) {
	$contentMan->Parse( "./text/Associations_" . $_GET[ "lang" ] . ".txt" );
}

function printWordCard( $contentMan, $cathegorie, $level, $word ) {
	?>
	<div>
		<h1>
			<?php 
			echo "$word"; 
			?>
		</h1>
		<img src="images/<?php echo $contentMan->GetImage( $cathegorie, $level, $word ); ?>"></img>
		<br/>
		<audio controls>
			<source src="sounds/<?php echo $contentMan->GetSound( $cathegorie, $level, $word ); ?>">
		</audio>
	<?php
}

function printWords( $contentMan, $cathegorie, $level ) {
	?>
	<div>
		<h1><?php echo "$level"; ?></h1>
		<?php
		if ( empty( $_GET[ "word" ] ) || $_GET[ "word" ] == "all" ) {
			$words = $contentMan->GetWords( $cathegorie, $level );
			foreach ($words as $word) {
				printWordCard( $contentMan, $cathegorie, $level, $word );
			}
		}
		else {
			printWordCard( $contentMan, $cathegorie, $level, $_GET[ "word" ] );
		}
		?>
	</div>
	<?php
}

function printLevels( $contentMan, $cathegorie ) {
	?>
	<div>
		<h1><?php echo "$cathegorie"; ?></h1>
		<?php
		if ( empty( $_GET[ "level" ] ) || $_GET[ "level" ] == "all" ) {
			$levels = $contentMan->GetLevels( $cathegorie );
			foreach ( $levels as $level ) {
				printWords( $contentMan, $cathegorie, $level );
			}
		}
		else {
			printWords( $contentMan, $cathegorie, $_GET[ "level" ] );
		}
		?>
	</div>
	<?php
}

function printCathegories( $contentMan ) {
	if ( ! empty( $_GET[ "cathegorie" ] ) ) {
		?>
		<div>
			<?php
			printLevels( $contentMan, $_GET[ "cathegorie" ] );
			?>
		</div>
		<?php
	}
}


function printLanguageOptions( $buttonText ) {
	?>
	<option value="<?php echo "$buttonText"; ?>" 
		<?php
		 if ( ! empty( $_GET[ "lang" ] ) && $_GET[ "lang" ] == $buttonText ) {
		 	echo "selected";
		 } 
		 ?> >
		<?php echo $buttonText; ?>
	</option>
	<?php
}

function printLanguagesSelect( $assocFiles ) {
	?>
	<select id="languages" name="lang">
		<?php
		foreach ( $assocFiles as $assocFile ) {
			if ( preg_match( "/^Associations_.+\.txt/", $assocFile ) ) {
				$language = substr( $assocFile, 13, -4 );
				printLanguageOptions( $language );
			}
		}
		?>
	</select>
	<?php
}

function printCathegoriesSelect( $contentMan ) {
	?>
	<select id="cathegories" name="cathegorie">
		<?php
		$cathegories = $contentMan->GetCathegories();
		foreach ($cathegories as $cathegorie ) {
			?>
			<option value="<?php echo "$cathegorie"; ?>"
				<?php
				if ( ! empty( $_GET[ "cathegorie" ] ) && $cathegorie == $_GET[ "cathegorie" ] ) {
					echo "selected";
				}
				?> >
				<?php
				echo "$cathegorie";
				?>
			</option>
			<?php
		}
		?>
	</select>
	<?php
}

function printLevelsSelect( $contentMan ) {
	?>
	<select id="levels" name="level">
		<option value="all">afficher tout</option>
		<?php
		$levels = $contentMan->GetLevels( $_GET[ "cathegorie" ] );
		foreach ($levels as $level ) {
			?>
			<option value="<?php echo "$level"; ?>"
				<?php 
				if ( ! empty( $_GET[ "level" ] ) && $level == $_GET[ "level" ] ) {
					echo "selected";
				}
				?> >
				<?php
				echo "$level";
				?>
			</option>
			<?php
		}
		?>
	</select>
	<?php	
}

function printWordsSelect( $contentMan ) {
	?>
	<select id="words" name="word">
		<option value="all">afficher tout</option>
		<?php
		$words = $contentMan->GetWords( $_GET[ "cathegorie" ], $_GET[ "level" ] );
		foreach ($words as $word ) {
			?>
			<option value="<?php echo "$word"; ?>"
				<?php
				if ( ! empty( $_GET[ "word" ] ) && $word == $_GET[ "word" ] ) {
					echo "selected";
				}
				?> >
				<?php
				echo "$word";
				?>
			</option>
			<?php
		}
		?>
	</select>
	<?php
}

function printSelections( $assocFiles, $contentMan ) {
	?>
	<form method="GET">
		<div>
			<?php
			printLanguagesSelect( $assocFiles );
			if ( ! empty( $_GET[ "lang" ] ) ) {
				printCathegoriesSelect( $contentMan );
				if ( ! empty( $_GET[ "cathegorie" ] ) ) {
					printLevelsSelect( $contentMan );
					if ( ! empty( $_GET[ "level" ] ) ) {
						printWordsSelect( $contentMan );
					}
				}
			}
			?>
		</div>
		<br/>
		<input type="submit" value="Rechercher" />
	</form>
	<?php
}

?>
<html>
<div>
	<?php
	printSelections( $assocFiles, $contentMan );
	printCathegories( $contentMan );
	?>
</div>
</html>
