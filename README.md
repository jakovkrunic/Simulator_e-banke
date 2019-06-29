# Simulator e-banke

Korisnik vidi stanje svojih računa te pripadne promete. Također može vršiti razne transakcije, i odabrati datum kada će se izvršiti. Bit će i opcija periodičkog plaćanja (npr. ako korisnik plaća pretplatu za mobitel, može automatizirati plaćanje svaki mjesec); ovdje će biti definirana gornja granica s kojom je postupak automatiziran, a za veće iznose će korisnik svejedno svaki mjesec morati potvrditi da želi izvršiti tu transakciju. Naravno, korisnik može i spremati predloške za plaćanja. Postoji i opcija štednje (oročene i sl.), pregled kredita i raznih dugovanja. Također postoji i kalkulator poreza, prireza i doprinosa, te tečajnu lista. Korisnik će moći vidjeti i koje poslovnice banke su blizu njega, te dobiti upute kako doći do nje. Administrativni dio: administrator može dodavati nove korisnike u sustav i brisati već postojeće, moze prekidati transakcije, odobravati kredite.

# Napomene

Datumi su oblika yyyy-mm-dd.

Opcije u izborniku (naslovnica, računi, transakcije ...) imaju svoje controllere i view-ove. Tako možemo lakše podijeliti poslove i nema mogućnosti konflikta.

Petra: Složen je admin header tako da samo za njega postoji mogućnost odobravanja korisnika i odobravanja računa za sad (u login controlleru se vrši preusmjeravanje)
