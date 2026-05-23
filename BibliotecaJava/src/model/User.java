package model;

// Herança: User herda de Person
public class User extends Person {
    private String  address;
    private boolean hasActiveLoan;

    public User(int id, String name, String phone, String email, String address) {
        super(id, name, phone, email);
        this.address       = address;
        this.hasActiveLoan = false;
    }

    public String  getAddress()              { return address; }
    public void    setAddress(String a)      { this.address = a; }
    public boolean hasActiveLoan()           { return hasActiveLoan; }
    public void    setHasActiveLoan(boolean b){ this.hasActiveLoan = b; }

    @Override
    public String getInfo() {
        return String.format("[ID:%d] %-25s | Tel: %-16s | Email: %-28s | Endereço: %-30s | Empréstimo ativo: %s",
                id, name, phone, email, address, hasActiveLoan ? "SIM" : "Não");
    }
}
