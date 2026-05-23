package controller;

import model.User;

import java.util.*;
import java.util.stream.Collectors;

public class UserController {
    private final List<User> users  = new ArrayList<>();
    private       int        nextId = 1;

    public User add(String name, String phone, String email, String address) {
        if (name == null || name.isBlank())
            throw new IllegalArgumentException("Nome não pode ser vazio.");
        User u = new User(nextId++, name.trim(), phone.trim(), email.trim(), address.trim());
        users.add(u);
        return u;
    }

    public boolean remove(int id) {
        User u = findById(id);
        if (u == null) return false;
        if (u.hasActiveLoan())
            throw new IllegalStateException("Usuário possui empréstimo ativo. Realize a devolução antes de remover.");
        return users.removeIf(user -> user.getId() == id);
    }

    public User findById(int id) {
        return users.stream().filter(u -> u.getId() == id).findFirst().orElse(null);
    }

    public List<User> searchByName(String name) {
        return users.stream()
                .filter(u -> u.getName().toLowerCase().contains(name.toLowerCase()))
                .collect(Collectors.toList());
    }

    public List<User> getAll() {
        return Collections.unmodifiableList(users);
    }

    public int  getNextId()          { return nextId; }
    public void setNextId(int nextId){ this.nextId = nextId; }
}
