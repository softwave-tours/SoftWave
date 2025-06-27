<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    $sujet = htmlspecialchars($_POST['sujet']);
    $message = htmlspecialchars($_POST['message']);

    // Détection du mot "stage" dans le sujet ou le message (insensible à la casse)
    if (preg_match('/\bstage\b/i', $sujet) || preg_match('/\bstage\b/i', $message)) {
        // "Stage" détecté -> réponse automatique au visiteur, pas à toi
        $subject = "Réponse automatique - Candidature Stage";
        $body = "Bonjour $nom,\n\nMerci pour votre intérêt.\n\nCependant, nous n'acceptons pas actuellement de candidatures pour des stages.\n\nNous vous souhaitons bonne continuation dans vos recherches.\n\nCordialement,\nL'équipe.";

        $headers = "From: no-reply@tonsite.com\r\n";
        $headers .= "Reply-To: no-reply@tonsite.com\r\n";

        if (mail($email, $subject, $body, $headers)) {
            echo "Message automatique envoyé avec succès.";
        } else {
            echo "Erreur lors de l'envoi du message automatique.";
        }

    } else {
        // Aucune mention de "stage" -> envoi normal vers toi
        $to = "ton-email@example.com"; // adresse qui reçoit les vrais messages
        $subject = "Nouvelle demande de $nom : $sujet";
        $body = "Nom: $nom\nEmail: $email\n\nMessage:\n$message";

        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";

        if (mail($to, $subject, $body, $headers)) {
            echo "Message envoyé avec succès.";
        } else {
            echo "Erreur lors de l'envoi du message.";
        }
    }
}
?>
