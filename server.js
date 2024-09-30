import express from "express"
import bodyParser from "body-parser"
import bcrypt from "bcrypt"

const app = express();
const port = 3000;

const users = [];

let userIsLoggedIn;

app.use(express.json());

app.use(express.static("public"));
app.use(bodyParser.urlencoded({ extended: true }));

app.get("/", (req, res) => {
    res.render("login.ejs");
});

app.post("/signup", async (req, res) => {
    const user = users.find(user => user.email === req.body.email);
    if (user) {
        return res.render("login.ejs", {mensagemEmail: "Esse email já está cadastrado"});
    } else {
        try {
            const salt = await bcrypt.genSalt();
            const hashedPassword = await bcrypt.hash(req.body.password, salt);
            console.log(salt);
            console.log(hashedPassword);
            const user = { email: req.body.email, password: hashedPassword}
            users.push(user);

            res.render("login.ejs");
            res.status(201);

        } catch (error) {
            res.render("login.ejs");
            res.status(500);
        }
    }
    
});

app.post("/home", async (req, res) => {
    const user = users.find(user => user.email === req.body.email);
    if (user == null) {
        res.render("login.ejs", { mensagem: "Email ou senha inválido" });
    } try {
        if (await bcrypt.compare(req.body.password, user.password)) {
            res.render("index.ejs");
            userIsLoggedIn = true
        } else {
            res.render("login.ejs", { mensagem: "Email ou senha inválido" });
        }
    } catch (error) {
        res.status(500);
    }
});

app.get("/home", (req, res) => {
    res.render("index.ejs");
})

app.get("/login", (req, res) => {
    res.render("login.ejs")
});

app.get("/projects", (req, res) => {
    if (userIsLoggedIn) {
        res.render("projects.ejs");
    } else {
        res.render("login.ejs");
    }

});

app.get("/about", (req, res) => {
    if (userIsLoggedIn) {
        res.render("about.ejs");
    } else {
        res.render("login.ejs");
    }
});

app.get("/contacts", (req, res) => {
    if (userIsLoggedIn) {
        res.render("contacts.ejs");
    } else {
        res.render("login.ejs");
    }
});

app.listen(port, () => {
    console.log(`Server running on port ${port}`);
});