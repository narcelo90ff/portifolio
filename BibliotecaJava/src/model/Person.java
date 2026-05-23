package model;

// Abstração: classe abstrata para qualquer pessoa no sistema
public abstract class Person {
    protected int    id;
    protected String name;
    protected String phone;
    protected String email;

    public Person(int id, String name, String phone, String email) {
        this.id    = id;
        this.name  = name;
        this.phone = phone;
        this.email = email;
    }

    public int    getId()           { return id; }
    public String getName()         { return name; }
    public void   setName(String n) { this.name = n; }
    public String getPhone()        { return phone; }
    public void   setPhone(String p){ this.phone = p; }
    public String getEmail()        { return email; }
    public void   setEmail(String e){ this.email = e; }

    public abstract String getInfo();

    @Override
    public String toString() { return getInfo(); }
}
