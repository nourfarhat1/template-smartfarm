<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Événements Agricoles</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 1rem 0;
        }

        h1 {
            margin: 0;
            font-size: 2rem;
        }

        main {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .actions a {
            padding: 6px 12px;
            border: 1px solid #4CAF50;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
        }

        .actions a:hover {
            background-color: #4CAF50;
            color: white;
        }

        footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
            color: #777;
        }
    </style>
</head>
<body>
    <header>
        <h1>Liste des Événements Agricoles</h1>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($events) && is_array($events)): ?>
                    <?php foreach ($events as $event): ?>
                        <tr>
                            <td><?= htmlspecialchars($event['id_e']); ?></td>
                            <td><?= htmlspecialchars($event['nom']); ?></td>
                            <td><?= htmlspecialchars($event['disc']); ?></td>
                            <td><?= htmlspecialchars($event['date']); ?></td>
                            <td class="actions">
                                <a href="edit.php?id=<?= $event['id_e']; ?>">Modifier</a>
                                <a href="copy.php?id=<?= $event['id_e']; ?>">Dupliquer</a>
                                <a href="delete.php?id=<?= $event['id_e']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Aucun événement trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
    <footer>
        © 2024 Agriculture Événements. Tous droits réservés.
    </footer>
</body>
</html>
