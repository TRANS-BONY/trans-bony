<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Barryvdh\DomPDF\Facade\Pdf;

class GenerateDocumentation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-doc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a PDF documentation for the Trans Bony project';

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
                h1 { color: #0056b3; text-align: center; border-bottom: 2px solid #0056b3; padding-bottom: 10px; }
                h2 { color: #2e8b57; margin-top: 30px; border-bottom: 1px solid #ccc; padding-bottom: 5px; }
                h3 { color: #333; margin-top: 20px; }
                p { text-align: justify; }
                ul { margin-top: 10px; }
                li { margin-bottom: 8px; }
                .footer { text-align: center; font-size: 12px; margin-top: 50px; color: #777; border-top: 1px solid #ddd; padding-top: 10px; }
                .cover { text-align: center; margin-top: 100px; margin-bottom: 100px; }
                .cover h1 { font-size: 3em; border: none; }
                .cover p { font-size: 1.5em; color: #555; text-align: center; }
                .page-break { page-break-after: always; }
            </style>
        </head>
        <body>
            <div class="cover">
                <h1>DOCUMENTATION DU PROJET<br>TRANS BONY</h1>
                <p>Système Intégré de Gestion de Flotte Automobile</p>
                <p><br><br>Généré automatiquement par le système le ' . now()->format('d/m/Y') . '</p>
            </div>
            
            <div class="page-break"></div>

            <h2>1. Présentation Générale du Projet</h2>
            <p><strong>Trans Bony</strong> est une application web métier (ERP) développée sous le framework Laravel, destinée à numériser, automatiser et centraliser l\'ensemble des processus liés à la gestion d\'une flotte de véhicules de transport (bus, camions, voitures de location, etc.).</p>
            <p><strong>Son impact :</strong> Le projet permet de passer d\'une gestion manuelle (papiers, classeurs, fichiers Excel disparates) à une plateforme collaborative en temps réel. Il réduit les erreurs humaines, prévient les pertes financières (suivi du carburant, alertes sur les pièces usées), garantit la conformité légale (alertes sur l\'expiration des documents comme l\'assurance) et optimise la rentabilité globale de l\'entreprise.</p>

            <h2>2. Rôles et Architecture des Accès</h2>
            <p>Le système est basé sur une architecture multi-rôles hautement sécurisée. Chaque employé n\'a accès qu\'aux modules qui concernent son métier, garantissant ainsi la confidentialité et l\'intégrité des données :</p>
            <ul>
                <li><strong>Administrateur (Admin) :</strong> A un accès illimité à toute la plateforme. Il peut créer des utilisateurs, attribuer des rôles, consulter les audits système et paramétrer les configurations globales.</li>
                <li><strong>Gestionnaire / Manager :</strong> Supervise l\'exploitation quotidienne. Il s\'assure du bon fonctionnement des véhicules, de la rentabilité des voyages et de l\'assiduité des chauffeurs.</li>
                <li><strong>Technicien (Mécanicien) :</strong> Est focalisé sur l\'état du parc automobile. Il s\'occupe du module de maintenance et remonte les problèmes techniques.</li>
                <li><strong>Comptable :</strong> N\'a accès qu\'aux modules financiers (recettes, suivi de carburant, rapports financiers) pour établir le bilan économique de la structure sans interférer avec la mécanique.</li>
                <li><strong>Agent :</strong> Gère les opérations de terrain, comme l\'assignation des bus et l\'enregistrement des voyages journaliers.</li>
            </ul>

            <div class="page-break"></div>

            <h2>3. Fonctionnement et Rôle des Modules</h2>
            
            <h3>A. Module Véhicules</h3>
            <p>C\'est le cœur de l\'application. Ce module centralise le registre de tout le parc automobile. Il conserve l\'historique du kilométrage, l\'immatriculation, la capacité, et le statut en temps réel (Disponible, En mission, En maintenance). Il impacte directement tous les autres modules car un véhicule "En maintenance" ne peut pas être assigné à un voyage.</p>

            <h3>B. Module Chauffeurs</h3>
            <p>Il permet de gérer les ressources humaines roulantes de l\'entreprise. Il enregistre les numéros de permis, les contacts, et la disponibilité des conducteurs. Un chauffeur inactif ou sans permis valide ne peut pas prendre le volant.</p>

            <h3>C. Module Voyages & Trajets</h3>
            <p>C\'est la planification opérationnelle. Il relie un Véhicule, un Chauffeur, une Destination et une Date. Ce module est critique car il définit l\'activité génératrice de revenus. Il est directement couplé à la mise à jour kilométrique des véhicules à leur retour de trajet.</p>

            <h3>D. Module Maintenances (Entretien technique)</h3>
            <p>Géré principalement par les techniciens, ce module archive les réparations (vidange, changement de pneus, panne mécanique). Il a un rôle préventif et permet de calculer les coûts d\'entretien pour évaluer la rentabilité d\'un véhicule sur le long terme.</p>

            <h3>E. Module Documents (Conformité légale)</h3>
            <p>Il stocke numériquement les cartes grises, assurances et visites techniques. <strong>Impact majeur :</strong> Il protège l\'entreprise des amendes. Le système génère automatiquement des notifications visuelles lorsque la date d\'expiration d\'un document approche.</p>

            <h3>F. Module Suivi de Carburant</h3>
            <p>Permet d\'enregistrer chaque ravitaillement à la pompe. Il impose un <strong>seuil de contrôle strict (prix minimum de 750 FCFA/litre)</strong> pour éviter les erreurs de saisie ou les fraudes. Son rôle est de calculer la consommation moyenne aux 100 km et d\'identifier les véhicules qui consomment anormalement.</p>

            <h3>G. Module Recettes (Finances)</h3>
            <p>Centralise les flux d\'argent entrants (billetterie, location, fret). Associé au module carburant et maintenance (dépenses), il permet au comptable de dégager la marge bénéficiaire nette par véhicule.</p>

            <h3>H. Module Rapports et Audits</h3>
            <ul>
                <li><strong>Rapports :</strong> Génère des bilans synthétiques (PDF/Excel) de l\'activité sur une période donnée.</li>
                <li><strong>Audits (Traçabilité) :</strong> C\'est le "détective" de l\'application. Chaque création, modification ou suppression (ex: un utilisateur supprime un voyage) est enregistrée avec la date et le nom de l\'utilisateur. Cela empêche les malversations.</li>
            </ul>

            <div class="footer">
                Document généré automatiquement par l\'application Trans Bony
            </div>
        </body>
        </html>
        ';

        $pdf = Pdf::loadHTML($html);
        $pdf->setPaper('A4', 'portrait');
        
        $path = public_path('Documentation_Trans_Bony.pdf');
        $pdf->save($path);

        $this->info("Documentation PDF générée avec succès : " . $path);
    }
}
