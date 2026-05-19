<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Barryvdh\DomPDF\Facade\Pdf;

class GenerateUserManual extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-manual';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a PDF user manual for the Trans Bony project';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $html = '
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: "Helvetica", "Arial", sans-serif; color: #333; line-height: 1.6; }
                h1 { color: #059669; text-align: center; border-bottom: 2px solid #059669; padding-bottom: 10px; }
                h2 { color: #0284c7; margin-top: 30px; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px; }
                h3 { color: #1e293b; margin-top: 20px; }
                p { text-align: justify; font-size: 14px; }
                ul, ol { margin-top: 10px; font-size: 14px; }
                li { margin-bottom: 8px; }
                .footer { text-align: center; font-size: 12px; margin-top: 50px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 10px; }
                .cover { text-align: center; margin-top: 100px; margin-bottom: 100px; }
                .cover h1 { font-size: 3em; border: none; color: #1e40af; }
                .cover p { font-size: 1.5em; color: #475569; text-align: center; }
                .page-break { page-break-after: always; }
                .note { background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 10px; margin: 15px 0; font-size: 13px; }
                .tip { background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 10px; margin: 15px 0; font-size: 13px; }
                .warning { background-color: #fef2f2; border-left: 4px solid #ef4444; padding: 10px; margin: 15px 0; font-size: 13px; }
            </style>
        </head>
        <body>
            <div class="cover">
                <h1>MANUEL D\'UTILISATION</h1>
                <p>TRANS BONY ERP</p>
                <p style="font-size: 1.2em; margin-top: 20px;">Système Intégré de Gestion de Flotte Automobile</p>
                <p><br><br>Généré automatiquement le ' . now()->format('d/m/Y') . '</p>
            </div>
            
            <div class="page-break"></div>

            <h2>1. Démarrage et Connexion</h2>
            <ol>
                <li><strong>Accès au portail :</strong> Ouvrez votre navigateur internet et rendez-vous sur l\'adresse de la plateforme.</li>
                <li><strong>Authentification :</strong> Entrez votre adresse e-mail professionnelle et votre mot de passe.</li>
                <li><strong>Tableau de bord :</strong> Dès la connexion, le système reconnaît automatiquement votre <strong>Rôle</strong> (Admin, Manager, Comptable, Technicien, Agent) et vous affiche un tableau de bord personnalisé avec vos statistiques clés.</li>
            </ol>
            <div class="note">
                <strong>Note :</strong> Le système de navigation est conçu "sans défilement global" (No-Scroll). Les menus restent toujours accessibles à gauche, et seules les listes de données défilent au centre pour un confort optimal.
            </div>

            <h2>2. Le Cycle Opérationnel Quotidien (Workflow)</h2>
            <p>La force de Trans Bony est d\'interconnecter les départements. Voici comment un véhicule passe de l\'affectation à la route, puis à la maintenance.</p>

            <h3>Étape 1 : S\'assurer des ressources (Véhicules & Chauffeurs)</h3>
            <p>Avant de lancer un trajet, le parc doit être à jour.</p>
            <ul>
                <li><strong>Aller dans le module "Véhicules" :</strong> Vous pouvez y ajouter de nouveaux bus, vérifier leur capacité, et consulter leur kilométrage actuel. Assurez-vous que le statut du véhicule est sur <strong>"Disponible"</strong>.</li>
                <li><strong>Aller dans le module "Chauffeurs" :</strong> Vérifiez que le chauffeur assigné possède un numéro de permis valide et qu\'il est marqué comme <strong>"Actif"</strong>.</li>
            </ul>

            <h3>Étape 2 : Planifier un Voyage</h3>
            <p>C\'est l\'action principale pour générer de l\'activité.</p>
            <ol>
                <li>Allez dans le module <strong>Voyages</strong>.</li>
                <li>Cliquez sur le bouton <strong>+ Nouveau Voyage</strong>.</li>
                <li>Sélectionnez le <strong>véhicule</strong> et le <strong>chauffeur</strong> dans les listes déroulantes.</li>
                <li>Entrez la <strong>destination</strong>, la <strong>date de départ</strong>, le <strong>type</strong> de voyage et le <strong>kilométrage de départ</strong> (affiché sur le compteur du bus à l\'instant T).</li>
                <li>Validez. Le statut du véhicule passera automatiquement en mode "En mission".</li>
            </ol>

            <h3>Étape 3 : Fin du Voyage et mise à jour du Kilométrage</h3>
            <p>Une fois le bus revenu au terminal :</p>
            <ol>
                <li>Retournez dans le module <strong>Voyages</strong> et modifiez le trajet correspondant.</li>
                <li>Remplissez le champ <strong>"Kilométrage d\'arrivée"</strong>.</li>
                <li><strong>Impact :</strong> Le système va calculer automatiquement la distance parcourue et mettra à jour le kilométrage global du véhicule dans sa fiche technique.</li>
            </ol>

            <div class="page-break"></div>

            <h2>3. Gestion Financière (Pour Comptables et Managers)</h2>

            <h3>Enregistrer une Recette</h3>
            <p>Une fois le voyage terminé, il faut encaisser l\'argent généré.</p>
            <ol>
                <li>Allez dans <strong>Recettes</strong>.</li>
                <li>Cliquez sur <strong>Ajouter</strong>.</li>
                <li>Associez la recette au <strong>véhicule</strong> concerné, choisissez le type (Billet, Fret, Location), définissez la date et entrez le <strong>montant</strong>.</li>
            </ol>
            <div class="tip">
                <strong>Astuce :</strong> Toutes les recettes d\'un même véhicule sont regroupées dans sa fiche "Détail" pour évaluer sa rentabilité.
            </div>

            <h3>Gérer le Carburant (Ravitaillement)</h3>
            <p>C\'est le module de contrôle des dépenses.</p>
            <ol>
                <li>Allez dans <strong>Suivi Carburant</strong>.</li>
                <li>Enregistrez la date, la station-service, les litres mis dans le réservoir et le <strong>montant total</strong>.</li>
                <li>Renseignez le kilométrage affiché au moment du plein.</li>
            </ol>
            <div class="warning">
                <strong>Sécurité du Seuil :</strong> Si l\'opérateur tente d\'enregistrer une valeur où le prix au litre est inférieur à 750 FCFA, le système bloquera l\'enregistrement pour éviter les fautes de frappe et la fraude.
            </div>

            <h2>4. Maintenance technique et Conformité (Pour Techniciens)</h2>

            <h3>Créer un rapport de Maintenance</h3>
            <p>Lorsqu\'un bus nécessite des réparations :</p>
            <ol>
                <li>Allez dans <strong>Maintenances</strong>.</li>
                <li>Cliquez sur <strong>Ajouter</strong> et sélectionnez le véhicule.</li>
                <li>Renseignez la description de la panne, le coût des réparations et le type d\'intervention (Vidange, Freins, Préventif).</li>
                <li>Le véhicule peut alors être passé temporairement en statut "Maintenance" dans sa fiche pour empêcher son affectation à un voyage.</li>
            </ol>

            <h3>Renouveler les Documents (Assurances, Visites techniques)</h3>
            <ol>
                <li>Allez dans <strong>Pièces & Documents</strong>.</li>
                <li>Ajoutez un nouveau document en indiquant sa <strong>date d\'émission</strong> et surtout sa <strong>date d\'expiration</strong>.</li>
                <li>Téléchargez une photo ou un scan PDF du document pour l\'archiver numériquement.</li>
            </ol>

            <div class="page-break"></div>

            <h2>5. Rapports & Audits (Direction)</h2>

            <h3>Exporter les données</h3>
            <ul>
                <li>Allez dans <strong>Rapports</strong>. Vous verrez des graphiques financiers générés automatiquement sur les 12 derniers mois.</li>
                <li>Cliquez sur <strong>Exporter en PDF</strong> ou <strong>Exporter en Excel</strong> pour générer un bilan prêt à être imprimé ou présenté au conseil d\'administration.</li>
            </ul>

            <h3>Consulter l\'Audit Trail</h3>
            <ul>
                <li>L\'<strong>Administrateur</strong> dispose d\'un accès au module <strong>Audits</strong>.</li>
                <li>Ce module est le "détective" de l\'application : Si un utilisateur modifie une recette passée ou supprime un voyage, l\'action est enregistrée avec l\'heure exacte et l\'adresse IP/Nom de l\'utilisateur.</li>
            </ul>

            <h2>6. Astuces et Navigation</h2>
            <ul>
                <li><strong>Recherche globale :</strong> Tous les modules possèdent une barre de recherche en haut à droite. Vous pouvez y taper une plaque d\'immatriculation, un nom, ou une date pour filtrer instantanément le tableau en cliquant sur la loupe.</li>
                <li><strong>Affichage condensé :</strong> Si vous travaillez sur un petit écran d\'ordinateur portable, n\'hésitez pas à réduire le menu latéral (si l\'option est présente) pour maximiser l\'espace des données.</li>
            </ul>

            <div class="footer">
                Manuel d\'utilisation généré automatiquement par l\'application Trans Bony
            </div>
        </body>
        </html>
        ';

        $pdf = Pdf::loadHTML($html);
        $pdf->setPaper('A4', 'portrait');
        
        $path = public_path('Manuel_Utilisateur_Trans_Bony.pdf');
        $pdf->save($path);

        $this->info("Manuel d'utilisation PDF généré avec succès : " . $path);
    }
}
