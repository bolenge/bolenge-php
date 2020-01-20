<h1>Bienvenue sur mon petit framework</h1>

<p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nihil ducimus inventore nesciunt itaque, ullam quam laboriosam veniam quaerat fuga veritatis sapiente mollitia iste, fugit porro provident ipsum quisquam. Nesciunt, sint.</p>

<h3>La liste des utilisateurs</h3>

<?php if (!empty($users)) : ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prenom</th>
            </tr>
        </thead>
    </table>
<?php endif ?>