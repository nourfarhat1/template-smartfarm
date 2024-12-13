<?php if (empty($_SESSION['panier'])) : ?>
    <p>Votre panier est vide.</p>
<?php else : ?>
    <?php foreach ($_SESSION['panier'] as $idproduit => $details) : ?>
        <div class="produit" data-idproduit="<?php echo $idproduit; ?>">
            <p class="nom">Nom : <?php echo htmlspecialchars($details['nom']); ?></p>
            <p class="prix">Prix : <?php echo htmlspecialchars($details['prix']); ?> dt</p>
            <div class="quantite">
                <button class="decrement" data-idproduit="<?php echo $idproduit; ?>">-</button>
                <span><?php echo $details['quantitepan']; ?></span>
                <button class="increment" data-idproduit="<?php echo $idproduit; ?>">+</button>
            </div>
            <p>Total produit : <?php echo $details['prix'] * $details['quantitepan']; ?> dt</p>
            <button class="supprimer" data-idproduit="<?php echo $idproduit; ?>">Supprimer</button>
        </div>
    <?php endforeach; ?>
    <h2 class="total">Total : <?php echo $total; ?> dt</h2>
<?php endif; ?>
