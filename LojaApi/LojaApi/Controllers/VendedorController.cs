
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using LojaApi.Data;
using LojaApi.Models;

namespace LojaApi.Controllers
{
    [ApiController]
    [Route("api/vendedor")]
    public class VendedorController : ControllerBase
    {
        private readonly AppDbContext _context;

        public VendedorController(AppDbContext context)
        {
            _context = context;
        }

        [HttpGet]
        public async Task<ActionResult<IEnumerable<Vendedor>>> GetAll()
        {
            var vendedores = await _context.Vendedores.ToListAsync();
            return Ok(vendedores);
        }

        [HttpPost]
        public async Task<ActionResult<Vendedor>> Create([FromBody] Vendedor vendedor)
        {
            if (!ModelState.IsValid)
                return BadRequest(ModelState);

            _context.Vendedores.Add(vendedor);
            await _context.SaveChangesAsync();

            return CreatedAtAction(nameof(GetAll), new { codigo = vendedor.Codigo }, vendedor);
        }

        [HttpPut("{codigo}")]
        public async Task<IActionResult> Update(int codigo, [FromBody] Vendedor vendedor)
        {
            if (codigo != vendedor.Codigo)
                return BadRequest("O código informado na URL não corresponde ao do corpo da requisição.");

            var existe = await _context.Vendedores.AnyAsync(v => v.Codigo == codigo);
            if (!existe)
                return NotFound($"Vendedor com código {codigo} não encontrado.");

            _context.Entry(vendedor).State = EntityState.Modified;

            try
            {
                await _context.SaveChangesAsync();
            }
            catch (DbUpdateConcurrencyException)
            {
                return StatusCode(500, "Erro ao atualizar o vendedor.");
            }

            return NoContent();
        }

        [HttpDelete("{codigo}")]
        public async Task<IActionResult> Delete(int codigo)
        {
            var vendedor = await _context.Vendedores.FindAsync(codigo);
            if (vendedor == null)
                return NotFound($"Vendedor com código {codigo} não encontrado.");

            _context.Vendedores.Remove(vendedor);
            await _context.SaveChangesAsync();

            return NoContent();
        }

        [HttpGet("salario/{valor}")]
        public async Task<ActionResult<IEnumerable<Vendedor>>> GetBySalario(decimal valor)
        {
            var vendedores = await _context.Vendedores
                .Where(v => v.Salario > valor)
                .ToListAsync();

            if (!vendedores.Any())
                return NotFound($"Nenhum vendedor encontrado com salário maior que {valor:C}.");

            return Ok(vendedores);
        }
    }
}